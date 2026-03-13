@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-4">Sistem Pendataan Budidaya Masyarakat</h1>
                <p class="lead mb-4">Platform untuk mendata potensi budidaya perikanan, aquaponik, dan tanaman obat keluarga (TOGA) di lingkungan masyarakat.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-person-plus"></i> Daftar Warga
                    </a>
                    <a href="{{ route('public.budidaya.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-tree"></i> Lihat Budidaya
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="https://via.placeholder.com/600x400/28a745/ffffff?text=Budidaya+System" alt="Hero Image" class="img-fluid rounded-3 shadow">
            </div>
        </div>
    </div>
</section>

<!-- Statistik Section -->
<section class="container mb-5">
    <h2 class="text-center mb-4" data-aos="fade-up">Statistik Budidaya</h2>
    <div class="row">
        <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card text-center">
                <i class="bi bi-people display-4"></i>
                <h3 class="mt-2">{{ $totalWarga }}</h3>
                <p>Warga Terdaftar</p>
            </div>
        </div>
        <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-card text-center">
                <i class="bi bi-house display-4"></i>
                <h3 class="mt-2">{{ $totalRumah }}</h3>
                <p>Rumah Terdata</p>
            </div>
        </div>
        <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-card text-center">
                <i class="bi bi-tree display-4"></i>
                <h3 class="mt-2">{{ $totalBudidaya }}</h3>
                <p>Total Budidaya</p>
            </div>
        </div>
        <div class="col-md-3 mb-3" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-card text-center">
                <i class="bi bi-pie-chart display-4"></i>
                <h3 class="mt-2">{{ $budidayaPerKategori->count() }}</h3>
                <p>Kategori</p>
            </div>
        </div>
    </div>
</section>

<!-- Kategori Section -->
<section class="container mb-5">
    <h2 class="text-center mb-4" data-aos="fade-up">Kategori Budidaya</h2>
    <div class="row">
        @foreach($budidayaPerKategori as $index => $kategori)
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
            <div class="card feature-card h-100">
                <div class="card-body text-center">
                    @if($kategori->nama_kategori == 'Perikanan')
                        <i class="bi bi-fish display-1 text-success"></i>
                    @elseif($kategori->nama_kategori == 'Aquaponic')
                        <i class="bi bi-water display-1 text-info"></i>
                    @else
                        <i class="bi bi-flower1 display-1 text-warning"></i>
                    @endif
                    <h4 class="mt-3">{{ $kategori->nama_kategori }}</h4>
                    <p class="display-6 fw-bold text-success">{{ $kategori->budidayas_count }}</p>
                    <p>Jumlah Budidaya</p>
                    <a href="{{ route('public.budidaya.filter', $kategori->id) }}" class="btn btn-outline-success">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Recent Budidaya Section -->
<section class="container mb-5">
    <h2 class="text-center mb-4" data-aos="fade-up">Budidaya Terbaru</h2>
    <div class="row">
        @foreach($recentBudidaya as $index => $budidaya)
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-{{ $budidaya->kategori->nama_kategori == 'Perikanan' ? 'primary' : ($budidaya->kategori->nama_kategori == 'Aquaponic' ? 'info' : 'warning') }}">
                            {{ $budidaya->kategori->nama_kategori }}
                        </span>
                        <small class="text-muted">{{ $budidaya->created_at->diffForHumans() }}</small>
                    </div>
                    <h5 class="card-title">{{ $budidaya->nama_budidaya }}</h5>
                    <p class="card-text">
                        <i class="bi bi-person"></i> {{ $budidaya->rumah->user->nama }}<br>
                        <i class="bi bi-geo-alt"></i> {{ Str::limit($budidaya->rumah->alamat, 50) }}<br>
                        <strong>{{ $budidaya->jumlah }} {{ $budidaya->satuan }}</strong>
                    </p>
                    <a href="{{ route('public.budidaya.detail', $budidaya->id) }}" class="btn btn-success w-100">
                        <i class="bi bi-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('public.budidaya.index') }}" class="btn btn-outline-success btn-lg">
            <i class="bi bi-grid"></i> Lihat Semua Budidaya
        </a>
    </div>
</section>

<!-- CTA Section -->
<section class="container mb-5">
    <div class="row">
        <div class="col-12">
            <div class="card bg-success text-white">
                <div class="card-body text-center p-5">
                    <h2 class="mb-4">Ingin Mendata Budidaya Anda?</h2>
                    <p class="lead mb-4">Daftar sekarang sebagai warga dan mulailah mendata potensi budidaya di rumah Anda.</p>
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-person-plus"></i> Daftar Warga
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection