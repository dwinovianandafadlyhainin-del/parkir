<?php
namespace App\Http\Controllers;
use App\Models\Location;
use App\Models\VehicleType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller {

    public function index() {
        $locations = Location::all();
        $vehicleTypes = VehicleType::all();
        $tickets = Transaction::with(['location','vehicleType'])
            ->whereNotNull('masuk')
            ->orderBy('created_at','desc')
            ->get();

        // Calculate available slots per location
        $locationSlots = [];
        foreach ($locations as $loc) {
            $parkedMotorcycle = Transaction::where('id_lokasi', $loc->id)
                ->whereHas('vehicleType', fn($q)=>$q->where('jenis','motorcycle'))
                ->whereNull('keluar')->count();
            $parkedCar = Transaction::where('id_lokasi', $loc->id)
                ->whereHas('vehicleType', fn($q)=>$q->where('jenis','car'))
                ->whereNull('keluar')->count();
            $parkedOther = Transaction::where('id_lokasi', $loc->id)
                ->whereHas('vehicleType', fn($q)=>$q->where('jenis','other'))
                ->whereNull('keluar')->count();

            $locationSlots[$loc->id] = [
                'motorcycle' => max(0, $loc->max_motorcycle - $parkedMotorcycle),
                'car' => max(0, $loc->max_car - $parkedCar),
                'other' => max(0, $loc->max_other - $parkedOther),
                'max_motorcycle' => $loc->max_motorcycle,
                'max_car' => $loc->max_car,
                'max_other' => $loc->max_other,
            ];
        }

        return view('transaction.index', compact('locations','vehicleTypes','tickets','locationSlots'));
    }

    public function enter(Request $request) {
        $request->validate([
            'id_lokasi' => 'required|exists:locations,id',
            'id_jenis' => 'required|exists:vehicle__types,id',
        ]);

        $vehicleType = VehicleType::findOrFail($request->id_jenis);
        $location = Location::findOrFail($request->id_lokasi);

        // Check capacity
        $parked = Transaction::where('id_lokasi', $request->id_lokasi)
            ->where('id_jenis', $request->id_jenis)
            ->whereNull('keluar')->count();

        $maxField = 'max_' . ($vehicleType->jenis === 'motorcycle' ? 'motorcycle' : ($vehicleType->jenis === 'car' ? 'car' : 'other'));
        if ($parked >= $location->$maxField) {
            return back()->with('error', 'Kapasitas parkir penuh!');
        }

        $now = now();
        $noTiket = $now->format('Ymd') . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);

        $transaction = Transaction::create([
            'id_lokasi' => $request->id_lokasi,
            'id_jenis' => $request->id_jenis,
            'no_tiket' => $noTiket,
            'masuk' => $now,
            'perjam_pertama' => $vehicleType->perjam_pertama,
            'perjam_berikutnya' => $vehicleType->perjam_berikutnya,
            'max_perhari' => $vehicleType->max_perhari,
        ]);

        // Generate PDF ticket
        $this->generateTicketPDF($transaction);

        return redirect()->route('transaction.index')->with('new_ticket', $transaction->id);
    }

    public function exit(Request $request) {
        $request->validate([
            'no_tiket' => 'required',
            'no_polisi' => 'required',
        ]);

        $transaction = Transaction::where('no_tiket', $request->no_tiket)
            ->whereNull('keluar')->firstOrFail();

        $now = now();
        $masuk = $transaction->masuk;
        // 1 minute = 1 hour (as per spec)
        $totalJam = (int) ceil($masuk->diffInMinutes($now));
        if ($totalJam < 1) $totalJam = 1;

        $totalDays = (int) floor($totalJam / 24);
        $totalBayar = 0;

        if ($totalJam > 24) {
            // More than 1 day: days * 60% of max_perhari
            $totalBayar = $totalDays * (int) round($transaction->max_perhari * 0.6);
        } else {
            // Within 24 hours
            $totalBayar = $transaction->perjam_pertama + ($transaction->perjam_berikutnya * ($totalJam - 1));
            if ($totalBayar > $transaction->max_perhari) {
                $totalBayar = $transaction->max_perhari;
            }
        }

        $transaction->update([
            'no_polisi' => $request->no_polisi,
            'keluar' => $now,
            'total_jam' => $totalJam,
            'total_bayar' => $totalBayar,
        ]);

        // Update ticket PDF with total bayar
        $this->generateTicketPDF($transaction->fresh()->load(['location','vehicleType']));

        return redirect()->route('transaction.index')
            ->with('total_bayar', $totalBayar)
            ->with('exit_ticket', $transaction->id);
    }

    public function getTicketByNumber(Request $request) {
        $transaction = Transaction::where('no_tiket', $request->no_tiket)
            ->whereNull('keluar')->first();
        if (!$transaction) {
            return response()->json(['error' => 'Tiket tidak ditemukan'], 404);
        }
        return response()->json(['no_tiket' => $transaction->no_tiket]);
    }

    public function allTransactions() {
        $transactions = Transaction::with(['location','vehicleType'])
            ->whereNotNull('keluar')
            ->orderBy('created_at','desc')
            ->get();
        return view('transaction.all', compact('transactions'));
    }

    public function viewPdf($id) {
        $transaction = Transaction::with(['location','vehicleType'])->findOrFail($id);
        $path = storage_path('app/public/tickets/' . $transaction->no_tiket . '.pdf');
        if (!file_exists($path)) {
            $this->generateTicketPDF($transaction);
        }
        return response()->file($path, ['Content-Type' => 'application/pdf']);
    }

    private function generateTicketPDF($transaction) {
        $transaction->load(['location','vehicleType']);
        $jenisLabel = match($transaction->vehicleType->jenis ?? '') {
            'motorcycle' => 'Motor',
            'car' => 'Mobil',
            'other' => 'Truck/Bus/Lainnya',
            default => '-'
        };
        $pdf = Pdf::loadView('transaction.ticket_pdf', [
            'transaction' => $transaction,
            'jenisLabel' => $jenisLabel,
        ]);
        $dir = storage_path('app/public/tickets');
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $pdf->save($dir . '/' . $transaction->no_tiket . '.pdf');
    }

    public function locationReport() {
        $locations = Location::withCount(['transactions as total_transactions'])->get();
        return view('report.location', compact('locations'));
    }

    public function transactionReport() {
        $transactions = Transaction::with(['location','vehicleType'])
            ->whereNotNull('keluar')
            ->orderBy('keluar','desc')
            ->get();
        return view('report.transaction', compact('transactions'));
    }
}
