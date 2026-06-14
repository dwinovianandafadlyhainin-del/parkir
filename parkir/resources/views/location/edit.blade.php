@extends('layouts.app')
@section('content')
<div class="topbar">
    <div>
        <div class="breadcrumb">Pages / Location</div>
        <span>Edit Location</span>
    </div>
    <div class="topbar-actions">
        <a href="{{ route('logout') }}" class="btn-sign-out"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
    </div>
</div>
<div class="page-content">
    <div class="form-card">
        <div class="form-title">Location Input Form</div>
        <form method="POST" action="{{ route('location.update', $location) }}">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Location Name</label>
                <input class="form-control" type="text" name="location_name" value="{{ old('location_name', $location->location_name) }}">
            </div>
            <div class="form-group">
                <label>Max Motorcycle</label>
                <input class="form-control" type="number" name="max_motorcycle" value="{{ old('max_motorcycle', $location->max_motorcycle) }}" min="0">
            </div>
            <div class="form-group">
                <label>Max Car</label>
                <input class="form-control" type="number" name="max_car" value="{{ old('max_car', $location->max_car) }}" min="0">
            </div>
            <div class="form-group">
                <label>Max Truck/Bus/Other</label>
                <input class="form-control" type="number" name="max_other" value="{{ old('max_other', $location->max_other) }}" min="0">
            </div>
            <div class="form-actions">
                <a href="{{ route('location.index') }}" class="btn-cancel">CANCEL</a>
                <button type="submit" class="btn-save">SAVE LOCATION</button>
            </div>
        </form>
    </div>
</div>
@endsection
