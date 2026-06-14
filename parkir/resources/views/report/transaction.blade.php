@extends('layouts.app')
@section('content')
<div class="topbar">
    <div>
        <div class="breadcrumb">Pages / Reports</div>
        <span>Transaction Report</span>
    </div>
    <div class="topbar-actions">
        <a href="{{ route('logout') }}" class="btn-sign-out"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
    </div>
</div>
<div class="page-content">
    <div class="card">
        <div class="card-header"><div class="card-title">Transaction Report</div></div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>TICKET</th>
                        <th>POLICE NO.</th>
                        <th>LOCATION</th>
                        <th>VEHICLE</th>
                        <th>TIME IN</th>
                        <th>TIME OUT</th>
                        <th>TOTAL JAM</th>
                        <th>TOTAL BAYAR</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $i => $t)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $t->no_tiket }}</td>
                        <td>{{ $t->no_polisi }}</td>
                        <td>{{ $t->location?->location_name }}</td>
                        <td>{{ $t->vehicleType?->jenis }}</td>
                        <td>{{ optional($t->masuk)->format('Y-m-d H:i:s') }}</td>
                        <td>{{ optional($t->keluar)->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $t->total_jam }}</td>
                        <td>Rp {{ number_format($t->total_bayar,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="9" style="text-align:center;color:#aaa;padding:32px;">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
