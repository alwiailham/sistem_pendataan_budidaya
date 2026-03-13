@extends('layouts.app')

@section('title', 'Data Rumah')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('rumah.index') }}" class="list-group-item list-group-item-action active">
                <i class="bi bi-house-door"></i> Data Rumah
            </a>
            <a href="{{ route('budidaya.index') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-tree"></i> Data Budidaya
            </a>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Rumah Saya</h5>
                <a href="{{ route('rumah.edit', $rumah->id) }}" class="btn btn-light btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Nama Pemilik</th>
                        <td>{{ Auth::user()->nama }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $rumah->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Telepon</th>
                        <td>{{ Auth::user()->nomor_telepon }}</td>
                    </tr>
                    <tr>
                        <th>Latitude</th>
                        <td>{{ $rumah->latitude }}</td>
                    </tr>
                    <tr>
                        <th>Longitude</th>
                        <td>{{ $rumah->longitude }}</td>
                    </tr>
                </table>

                <div class="mt-3">
                    <h6>Lokasi Rumah di Peta:</h6>
                    <div id="map" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    #map {
        border-radius: 5px;
        border: 1px solid #ddd;
    }
</style>
@endpush

@push('scripts')
<script>
    var map = L.map('map').setView([{{ $rumah->latitude }}, {{ $rumah->longitude }}], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    L.marker([{{ $rumah->latitude }}, {{ $rumah->longitude }}]).addTo(map)
        .bindPopup('Lokasi Rumah Saya')
        .openPopup();
</script>
@endpush