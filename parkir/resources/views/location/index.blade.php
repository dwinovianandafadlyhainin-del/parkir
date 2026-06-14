@extends('layouts.app')
@section('content')
<div class="topbar">
    <div>
        <div class="breadcrumb">Pages / Location</div>
        <span>Location</span>
    </div>
    <div class="topbar-actions">
        <div class="topbar-search">
            <i class="fa-solid fa-magnifying-glass" style="color:#bbb;"></i>
            <form method="GET" style="display:inline;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Type here...">
            </form>
        </div>
        <a href="{{ route('location.create') }}" class="btn-primary"><i class="fa-solid fa-plus"></i> ADD NEW LOCATION</a>
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
        <div class="card-header">
            <div class="card-title">Location Data Table</div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>LOCATION NAME</th>
                        <th>MAX MOTORCYCLE</th>
                        <th>MAX CAR</th>
                        <th>MAX TRUCK/BUS/OTHER</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $i => $loc)
                    <tr>
                        <td>{{ $i+1 }}.</td>
                        <td>{{ $loc->location_name }}</td>
                        <td>{{ $loc->max_motorcycle }}</td>
                        <td>{{ $loc->max_car }}</td>
                        <td>{{ $loc->max_other }}</td>
                        <td><a href="{{ route('location.edit', $loc) }}" class="btn-edit"><i class="fa-solid fa-pen"></i> EDIT</a></td>
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
