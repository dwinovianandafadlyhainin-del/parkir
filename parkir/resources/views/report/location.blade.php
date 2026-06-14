@extends('layouts.app')
@section('content')
<div class="topbar">
    <div>
        <div class="breadcrumb">Pages / Reports</div>
        <span>Location Report</span>
    </div>
    <div class="topbar-actions">
        <a href="{{ route('logout') }}" class="btn-sign-out"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
    </div>
</div>
<div class="page-content">
    <div class="card">
        <div class="card-header"><div class="card-title">Location Report</div></div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>LOCATION NAME</th>
                        <th>MAX MOTORCYCLE</th>
                        <th>MAX CAR</th>
                        <th>MAX TRUCK/BUS/OTHER</th>
                        <th>TOTAL TRANSACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $i => $loc)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $loc->location_name }}</td>
                        <td>{{ $loc->max_motorcycle }}</td>
                        <td>{{ $loc->max_car }}</td>
                        <td>{{ $loc->max_other }}</td>
                        <td>{{ $loc->total_transactions }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;color:#aaa;padding:32px;">No data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
