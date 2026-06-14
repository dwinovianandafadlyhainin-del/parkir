<?php
namespace App\Http\Controllers;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller {
    public function index(Request $request) {
        $query = VehicleType::query();
        if ($request->search) {
            $query->where('jenis', 'like', '%'.$request->search.'%');
        }
        $vehicleTypes = $query->get();
        return view('vehicle_type.index', compact('vehicleTypes'));
    }

    public function create() {
        return view('vehicle_type.create');
    }

    public function store(Request $request) {
        $request->validate([
            'jenis' => 'required|in:motorcycle,car,other',
            'perjam_pertama' => 'required|integer|min:0',
            'perjam_berikutnya' => 'required|integer|min:0',
            'max_perhari' => 'required|integer|min:0',
        ]);
        // Prevent duplicate jenis
        if (VehicleType::where('jenis', $request->jenis)->exists()) {
            return back()->withErrors(['jenis' => 'Vehicle type already exists.'])->withInput();
        }
        VehicleType::create($request->only(['jenis','perjam_pertama','perjam_berikutnya','max_perhari']));
        return redirect()->route('vehicle-type.index')->with('success', 'New Vehicle Type was successfully saved!');
    }

    public function edit(VehicleType $vehicleType) {
        return view('vehicle_type.edit', compact('vehicleType'));
    }

    public function update(Request $request, VehicleType $vehicleType) {
        $request->validate([
            'perjam_pertama' => 'required|integer|min:0',
            'perjam_berikutnya' => 'required|integer|min:0',
            'max_perhari' => 'required|integer|min:0',
        ]);
        $vehicleType->update($request->only(['perjam_pertama','perjam_berikutnya','max_perhari']));
        return redirect()->route('vehicle-type.index')->with('success', 'Vehicle Type updated successfully!');
    }
}
