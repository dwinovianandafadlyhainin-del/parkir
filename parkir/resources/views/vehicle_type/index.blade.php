@extends('layouts.app')
@section('content')
<div class="topbar">
    <div>
        <div class="breadcrumb">Pages / Vehicle Type</div>
        <span>Vehicle Type</span>
    </div>
    <div class="topbar-actions">
        <div class="topbar-search">
            <i class="fa-solid fa-magnifying-glass" style="color:#bbb;"></i>
            <form method="GET" style="display:inline;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Type here...">
            </form>
        </div>
        <a href="{{ route('vehicle-type.create') }}" class="btn-primary"><i class="fa-solid fa-plus"></i> ADD NEW VEHICLE TYPE</a>
        <a href="{{ route('logout') }}" class="btn-sign-out"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
    </div>
</div>
<div class="page-content">
    @if(session('success'))
    <div id="successModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon-success"><i class="fa-solid fa-check"></i></div>
            <div class="modal-title">Good Job</div>
            <div class="modal-text">{{ session('success') }}</div>
            <button class="modal-btn" onclick="document.getElementById('successModal').style.display='none'">OK</button>
        </div>
    </div>
    @endif
    <div class="card">
        <div class="card-header"><div class="card-title">Vehicle Type Data Table</div></div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>VEHICLE TYPE</th>
                        <th>FIRST HOUR CHARGES</th>
                        <th>NEXT HOURLY CHARGES</th>
                        <th>MAX COST PER DAY</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicleTypes as $i => $vt)
                    <tr>
                        <td>{{ $i+1 }}.</td>
                        <td>{{ ucfirst($vt->jenis) }}</td>
                        <td>Rp {{ number_format($vt->perjam_pertama,0,',','.') }}</td>
                        <td>Rp {{ number_format($vt->perjam_berikutnya,0,',','.') }}</td>
                        <td>Rp {{ number_format($vt->max_perhari,0,',','.') }}</td>
                        <td><a href="{{ route('vehicle-type.edit', $vt) }}" class="btn-edit"><i class="fa-solid fa-pen"></i> EDIT</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;color:#aaa;padding:32px;">No data available</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
