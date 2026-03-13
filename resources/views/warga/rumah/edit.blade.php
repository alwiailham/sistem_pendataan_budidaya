@extends('layouts.app')

@section('title', 'Edit Data Rumah')

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
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Edit Data Rumah</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('rumah.update', $rumah->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" rows="3" required>{{ old('alamat', $rumah->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control @error('latitude') is-invalid @enderror" 
                                   id="latitude" name="latitude" value="{{ old('latitude', $rumah->latitude) }}" readonly required>
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control @error('longitude') is-invalid @enderror" 
                                   id="longitude" name="longitude" value="{{ old('longitude', $rumah->longitude) }}" readonly required>
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih Lokasi di Peta</label>
                        <div id="map" style="height: 400px;"></div>
                        <small class="text-muted">Geser marker untuk menentukan lokasi rumah Anda</small>
                    </div>

                    <button type="submit" class="btn btn-success">Update Data Rumah</button>
                    <a href="{{ route('rumah.index') }}" class="btn btn-secondary">Batal</a>
                </form>
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
    
    var marker = L.marker([{{ $rumah->latitude }}, {{ $rumah->longitude }}], {draggable: true}).addTo(map);
    
    marker.on('dragend', function(e) {
        var position = marker.getLatLng();
        document.getElementById('latitude').value = position.lat.toFixed(6);
        document.getElementById('longitude').value = position.lng.toFixed(6);
    });
    
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('latitude').value = e.latlng.lat.toFixed(6);
        document.getElementById('longitude').value = e.latlng.lng.toFixed(6);
    });
</script>
@endpush