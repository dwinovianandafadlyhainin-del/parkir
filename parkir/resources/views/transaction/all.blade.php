@extends('layouts.app')
@push('styles')
<style>
.modal-overlay2 { position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:999;display:flex;align-items:center;justify-content:center; }
.modal-box2 { background:#fff;border-radius:16px;padding:32px;min-width:900px;max-width:95vw;box-shadow:0 10px 40px rgba(0,0,0,0.15); overflow-x:auto; }
.modal-close { background:#e91e8c;color:#fff;border:none;border-radius:6px;padding:8px 24px;font-size:13px;font-weight:700;cursor:pointer;margin-top:16px; }
</style>
@endpush
@section('content')
<div class="topbar">
    <div>
        <div class="breadcrumb">Pages / Transaction</div>
        <span>All Transactions</span>
    </div>
    <div class="topbar-actions">
        <a href="{{ route('transaction.index') }}" class="btn-sign-out"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>
</div>
<div class="page-content">
    <div class="card">
        <div class="card-header"><div class="card-title" style="color:#e91e8c;font-size:18px;">All Transactions</div></div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>TICKET NUMBER</th>
                        <th>POLICE NUMBER</th>
                        <th>LOCATION NAME</th>
                        <th>VEHICLE TYPE</th>
                        <th>TIME IN</th>
                        <th>TIME OUT</th>
                        <th>FIRST H.</th>
                        <th>NEXT H.</th>
                        <th>MAX/DAY</th>
                        <th>TOTAL H.</th>
                        <th>TOTAL DAYS</th>
                        <th>TOTAL PAY</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $i => $t)
                    <tr>
                        <td>{{ $i+1 }}.</td>
                        <td>
                            <a href="{{ route('transaction.pdf', $t->id) }}" target="_blank" style="color:#e91e8c;font-size:11px;">
                                <i class="fa-solid fa-file-pdf"></i> PDF
                            </a>
                            {{ $t->no_tiket }}
                        </td>
                        <td>{{ $t->no_polisi }}</td>
                        <td>{{ $t->location?->location_name }}</td>
                        <td>{{ $t->vehicleType?->jenis }}</td>
                        <td>{{ optional($t->masuk)->format('Y-m-d H:i:s') }}</td>
                        <td>{{ optional($t->keluar)->format('Y-m-d H:i:s') }}</td>
                        <td>Rp {{ number_format($t->perjam_pertama,0,',','.') }}</td>
                        <td>Rp {{ number_format($t->perjam_berikutnya,0,',','.') }}</td>
                        <td>Rp {{ number_format($t->max_perhari,0,',','.') }}</td>
                        <td>{{ $t->total_jam }}</td>
                        <td>{{ $t->total_jam ? floor($t->total_jam/24) : 0 }}</td>
                        <td>Rp {{ number_format($t->total_bayar,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="13" style="text-align:center;color:#aaa;padding:32px;">No transactions yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
