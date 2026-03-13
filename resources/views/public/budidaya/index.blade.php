@extends('layouts.public')

@section('title', 'Data Budidaya')

@section('content')
<!-- Page Header -->
<div class="bg-success text-white py-4 mb-4">
    <div class="container">
        <h1><i class="bi bi-tree"></i> Data Budidaya Masyarakat</h1>
        <p class="lead mb-0">Berikut adalah daftar budidaya yang telah didata oleh warga</p>
    </div>
</div>

<div class="container">
    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="btn-group" role="group">
                <a href="{{ route('public.budidaya.index') }}" class="btn {{ !isset($selectedKategori) ? 'btn-success' : 'btn-outline-success' }}">
                    Semua
                </a>
                @foreach($kategoris as $kategori)
                <a href="{{ route('public.budidaya.filter', $kategori->id) }}" 
                   class="btn {{ isset($selectedKategori) && $selectedKategori->id == $kategori->id ? 'btn-success' : 'btn-outline-success' }}">
                    {{ $kategori->nama_kategori }}
                </a>
                @endforeach
            </div>
        </div>
        <div class="col-md-4">
            <form action="{{ route('public.budidaya.search') }}" method="GET" class="d-flex">
                <input type="text" name="q" class="form-control me-2" placeholder="Cari budidaya, pemilik, atau alamat..." value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Budidaya Grid -->
    <div class="row">
        @forelse($budidayas as $budidaya)
        <div class="col-md-4 mb-4" data-aos="fade-up">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-{{ $budidaya->kategori->nama_kategori == 'Perikanan' ? 'primary' : ($budidaya->kategori->nama_kategori == 'Aquaponic' ? 'info' : 'warning') }} p-2">
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
                        <small class="text-muted">
                            <i class="bi bi-calendar"></i> {{ $budidaya->created_at->format('d/m/Y') }}
                        </small>
                    </div>
                    
                    <h5 class="card-title text-success">{{ $budidaya->nama_budidaya }}</h5>
                    
                    <div class="mb-3">
                        <p class="mb-1">
                            <i class="bi bi-person-circle text-success"></i>
                            <strong>{{ $budidaya->rumah->user->nama }}</strong>
                        </p>
                        <p class="mb-1 text-muted small">
                            <i class="bi bi-geo-alt"></i> {{ Str::limit($budidaya->rumah->alamat, 60) }}
                        </p>
                    </div>
                    
                    <div class="row text-center mb-3">
                        <div class="col-6 border-end">
                            <div class="fw-bold text-success">{{ $budidaya->jumlah }}</div>
                            <small class="text-muted">Jumlah</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-success">{{ $budidaya->satuan }}</div>
                            <small class="text-muted">Satuan</small>
                        </div>
                    </div>
                    
                    <a href="{{ route('public.budidaya.detail', $budidaya->id) }}" class="btn btn-success w-100">
                        <i class="bi bi-eye"></i> Lihat Detail & Lokasi
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle display-4 d-block"></i>
                <h4>Belum Ada Data Budidaya</h4>
                <p>Belum ada data budidaya yang tersedia saat ini.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12">
            {{ $budidayas->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-card {
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2) !important;
    }
    .pagination {
        justify-content: center;
    }
    .page-item.active .page-link {
        background-color: #28a745;
        border-color: #28a745;
    }
    .page-link {
        color: #28a745;
    }
    .page-link:hover {
        color: #20c997;
    }
</style>
@endpush