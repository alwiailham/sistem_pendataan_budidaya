@extends('layouts.public')

@section('title', 'Detail Budidaya')

@section('content')
<!-- Page Header -->
<div class="bg-success text-white py-4 mb-4">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.budidaya.index') }}" class="text-white">Budidaya</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Detail</li>
            </ol>
        </nav>
        <h1><i class="bi bi-tree"></i> Detail Budidaya</h1>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Informasi Budidaya -->
        <div class="col-md-5 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Budidaya</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <span class="badge bg-{{ $budidaya->kategori->nama_kategori == 'Perikanan' ? 'primary' : ($budidaya->kategori->nama_kategori == 'Aquaponic' ? 'info' : 'warning') }} p-3 fs-6">
                            <i class="bi 
                                @if($budidaya->kategori->nama_kategori == 'Perikanan')
                                    bi-fish
                                @elseif($budidaya->kategori->nama_kategori == 'Aquaponic')
                                    bi-water
                                @else
                                    bi-flower1
                                @endif
                            "></i>
                            {{ $budidaya->kategori->nama_kategori }}
                        </span>
                    </div>
                    
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Nama Budidaya</th>
                            <td>{{ $budidaya->nama_budidaya }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td><span class="fw-bold text-success">{{ $budidaya->jumlah }}</span> {{ $budidaya->satuan }}</td>
                        </tr>
                        <tr>
                            <th>Pemilik</th>
                            <td>{{ $budidaya->rumah->user->nama }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Telepon</th>
                            <td>{{ $budidaya->rumah->user->nomor_telepon }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $budidaya->rumah->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $budidaya->rumah->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Koordinat</th>
                            <td>{{ $budidaya->rumah->latitude }}, {{ $budidaya->rumah->longitude }}</td>
                        </tr>
                        <tr>
                            <th>Ditambahkan</th>
                            <td>{{ $budidaya->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Update</th>
                            <td>{{ $budidaya->updated_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Budidaya Lain dari Pemilik yang Sama -->
            @if($otherBudidaya->isNotEmpty())
            <div class="card shadow mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-tree"></i> Budidaya Lain dari {{ $budidaya->rumah->user->nama }}</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($otherBudidaya as $other)
                        <a href="{{ route('public.budidaya.detail', $other->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-{{ $other->kategori->nama_kategori == 'Perikanan' ? 'primary' : ($other->kategori->nama_kategori == 'Aquaponic' ? 'info' : 'warning') }} me-2">
                                        {{ $other->kategori->nama_kategori }}
                                    </span>
                                    {{ $other->nama_budidaya }}
                                </div>
                                <small>{{ $other->jumlah }} {{ $other->satuan }}</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Peta Lokasi -->
        <div class="col-md-7 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-map"></i> Lokasi Budidaya</h5>
                </div>
                <div class="card-body">
                    <div id="map" style="height: 500px;"></div>
                    
                    <div class="mt-3">
                        <button class="btn btn-success" onclick="window.open(`https://www.google.com/maps?q={{ $budidaya->rumah->latitude }},{{ $budidaya->rumah->longitude }}`, '_blank')">
                            <i class="bi bi-google"></i> Buka di Google Maps
                        </button>
                        <button class="btn btn-outline-success" onclick="copyCoordinates()">
                            <i class="bi bi-clipboard"></i> Salin Koordinat
                        </button>
                    </div>
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
    .table th {
        background-color: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script>
    // Inisialisasi peta
    var map = L.map('map').setView([{{ $budidaya->rumah->latitude }}, {{ $budidaya->rumah->longitude }}], 15);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Tambahkan marker
    var marker = L.marker([{{ $budidaya->rumah->latitude }}, {{ $budidaya->rumah->longitude }}]).addTo(map);
    
    // Popup dengan informasi
    var popupContent = `
        <div style="min-width: 200px;">
            <h6 class="text-success">{{ $budidaya->rumah->user->nama }}</h6>
            <p><strong>Alamat:</strong> {{ $budidaya->rumah->alamat }}</p>
            <p><strong>Budidaya:</strong> {{ $budidaya->nama_budidaya }} ({{ $budidaya->kategori->nama_kategori }})</p>
            <p><strong>Jumlah:</strong> {{ $budidaya->jumlah }} {{ $budidaya->satuan }}</p>
        </div>
    `;
    
    marker.bindPopup(popupContent).openPopup();
    
    // Fungsi copy koordinat
    function copyCoordinates() {
        var coords = "{{ $budidaya->rumah->latitude }}, {{ $budidaya->rumah->longitude }}";
        navigator.clipboard.writeText(coords).then(function() {
            alert('Koordinat berhasil disalin!');
        }).catch(function() {
            alert('Gagal menyalin koordinat');
        });
    }
</script>
@endpush