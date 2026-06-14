@extends('layouts.app')
@section('content')
<div class="topbar">
    <div>
        <div class="breadcrumb">Pages / Vehicle Type</div>
        <span>Vehicle Type</span>
    </div>
    <div class="topbar-actions">
        <a href="{{ route('logout') }}" class="btn-sign-out"><i class="fa-solid fa-right-from-bracket"></i> Sign Out</a>
    </div>
</div>
<div class="page-content">
    <div class="form-card">
        <div class="form-title">Vehicle Type Input Form</div>
        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('vehicle-type.store') }}">
            @csrf
            <div class="form-group">
                <label>Vehicle Type</label>
                <select class="form-control" name="jenis">
                    <option value="motorcycle" {{ old('jenis')=='motorcycle'?'selected':'' }}>Motorcycle</option>
                    <option value="car" {{ old('jenis')=='car'?'selected':'' }}>Car</option>
                    <option value="other" {{ old('jenis')=='other'?'selected':'' }}>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>First Hour Charges</label>
                <input class="form-control" type="number" name="perjam_pertama" value="{{ old('perjam_pertama', 2000) }}" min="0">
            </div>
            <div class="form-group">
                <label>Next Hourly Charges</label>
                <input class="form-control" type="number" name="perjam_berikutnya" value="{{ old('perjam_berikutnya', 1000) }}" min="0">
            </div>
            <div class="form-group">
                <label>Max Cost Per Day</label>
                <input class="form-control" type="number" name="max_perhari" value="{{ old('max_perhari', 10000) }}" min="0">
            </div>
            <div class="form-actions">
                <a href="{{ route('vehicle-type.index') }}" class="btn-cancel">CANCEL</a>
                <button type="submit" class="btn-save">SAVE VEHICLE TYPE</button>
            </div>
        </form>
    </div>
</div>
@endsection
