@extends('layouts.public')

@section('title', 'Data Budidaya')

@section('content')
<!-- Page Header -->
<div class="py-4 mb-4 text-white" style="background: linear-gradient(135deg, #c0392b, #e74c3c);">
    <div class="container">
        <h1><i class="bi bi-tree"></i> Data Budidaya Masyarakat</h1>
        <p class="lead mb-0">Berikut adalah daftar budidaya yang telah didata oleh warga</p>
    </div>
</div>

<div class="container">
    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="btn-group flex-wrap gap-1" role="group">
                <a href="{{ route('public.budidaya.index') }}" 
                   class="btn rounded-pill {{ !isset($selectedKategori) ? 'btn-danger' : 'btn-outline-danger' }}">
                    Semua
                </a>
                @foreach($kategoris as $kategori)
                <a href="{{ route('public.budidaya.filter', $kategori->id) }}" 
                   class="btn rounded-pill {{ isset($selectedKategori) && $selectedKategori->id == $kategori->id ? 'btn-danger' : 'btn-outline-danger' }}">
                    {{ $kategori->nama_kategori }}
                </a>
                @endforeach
            </div>
        </div>
        <div class="col-md-4 mt-3 mt-md-0">
            <form action="{{ route('public.budidaya.search') }}" method="GET" class="d-flex">
                <input type="text" name="q" class="form-control me-2 border-danger" 
                       placeholder="Cari budidaya, pemilik, atau alamat..." 
                       value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Budidaya Grid -->
    <div class="row">
        @forelse($budidayas as $budidaya)
        <div class="col-md-4 mb-4" data-aos="fade-up">
            <div class="card h-100 border-0 shadow-sm hover-card rounded-4">
                <!-- Card Top Accent -->
                <div class="rounded-top-4" style="height:5px; background: linear-gradient(90deg, #c0392b, #e74c3c);"></div>
                <div class="card-body pt-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge p-2 rounded-pill
                            @if($budidaya->kategori->nama_kategori == 'Perikanan')
                                text-white
                            @elseif($budidaya->kategori->nama_kategori == 'Aquaponic')
                                text-white
                            @else
                                text-white
                            @endif"
                            style="background:
                            @if($budidaya->kategori->nama_kategori == 'Perikanan')
                                #e74c3c
                            @elseif($budidaya->kategori->nama_kategori == 'Aquaponic')
                                #c0392b
                            @else
                                #922b21
                            @endif">
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

                    <h5 class="card-title fw-bold" style="color:#c0392b;">
                        {{ $budidaya->nama_budidaya }}
                    </h5>

                    <div class="mb-3">
                        <p class="mb-1">
                            <i class="bi bi-person-circle" style="color:#e74c3c;"></i>
                            <strong>{{ $budidaya->rumah->user->nama }}</strong>
                        </p>
                        <p class="mb-1 text-muted small">
                            <i class="bi bi-geo-alt" style="color:#e74c3c;"></i> 
                            {{ Str::limit($budidaya->rumah->alamat, 60) }}
                        </p>
                    </div>

                    <div class="row text-center mb-3 rounded-3 py-2 mx-0"
                         style="background: rgba(231,76,60,0.07);">
                        <div class="col-6 border-end">
                            <div class="fw-bold" style="color:#c0392b;">{{ $budidaya->jumlah }}</div>
                            <small class="text-muted">Jumlah</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold" style="color:#c0392b;">{{ $budidaya->satuan }}</div>
                            <small class="text-muted">Satuan</small>
                        </div>
                    </div>

                    <a href="{{ route('public.budidaya.detail', $budidaya->id) }}" 
                       class="btn w-100 text-white rounded-pill"
                       style="background: linear-gradient(135deg, #c0392b, #e74c3c);">
                        <i class="bi bi-eye"></i> Lihat Detail & Lokasi
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert text-center border-0 rounded-4" 
                 style="background: rgba(231,76,60,0.08); color:#c0392b;">
                <i class="bi bi-info-circle display-4 d-block mb-2"></i>
                <h4>Belum Ada Data Budidaya</h4>
                <p class="mb-0">Belum ada data budidaya yang tersedia saat ini.</p>
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
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(192,57,43,0.2) !important;
    }
    .pagination {
        justify-content: center;
    }
    .page-item.active .page-link {
        background-color: #c0392b;
        border-color: #c0392b;
    }
    .page-link {
        color: #c0392b;
    }
    .page-link:hover {
        color: #e74c3c;
        background-color: rgba(231,76,60,0.08);
    }
    input.border-danger:focus {
        border-color: #e74c3c !important;
        box-shadow: 0 0 0 0.2rem rgba(231,76,60,0.2);
    }
</style>
@endpush