@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="container-fluid px-0">

    {{-- Hero Section --}}
    <div class="rounded-4 mb-5 p-5 text-white text-center"
         style="background: linear-gradient(135deg, #1a7a4a 0%, #28a745 60%, #17a2b8 100%);">
        <h1 class="display-4 fw-bold mb-2">Sistem Pendataan Budidaya</h1>
        <p class="lead mb-4 opacity-75">Perikanan, Aquaponik, dan Tanaman Obat Keluarga (TOGA)</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 fw-semibold text-success">
                <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
            </a>
        </div>
    </div>

    {{-- Card Kategori --}}
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-3 rounded-4">
                <div class="card-body">
                    <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:80px; height:80px;">
                        <i class="bi bi-fish fs-1 text-success"></i>
                    </div>
                    <h4 class="fw-bold">Perikanan</h4>
                    <p class="text-muted">Pendataan budidaya ikan air tawar seperti lele, nila, gurame, dan lainnya.</p>
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Ikan Air Tawar</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-3 rounded-4">
                <div class="card-body">
                    <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:80px; height:80px;">
                        <i class="bi bi-water fs-1 text-info"></i>
                    </div>
                    <h4 class="fw-bold">Aquaponik</h4>
                    <p class="text-muted">Sistem budidaya tanaman dengan media air yang terintegrasi dengan ikan.</p>
                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">Sistem Terpadu</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-3 rounded-4">
                <div class="card-body">
                    <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:80px; height:80px;">
                        <i class="bi bi-flower1 fs-1 text-warning"></i>
                    </div>
                    <h4 class="fw-bold">TOGA</h4>
                    <p class="text-muted">Tanaman obat keluarga seperti jahe, kunyit, sereh, dan tanaman herbal lainnya.</p>
                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">Tanaman Herbal</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik & CTA --}}
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header border-0 rounded-top-4 py-3 px-4"
                     style="background: linear-gradient(135deg, #1a7a4a, #28a745);">
                    <h5 class="mb-0 text-white fw-semibold">
                        <i class="bi bi-bar-chart-fill me-2"></i>Statistik Budidaya
                    </h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="statistikChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header border-0 rounded-top-4 py-3 px-4"
                     style="background: linear-gradient(135deg, #1a7a4a, #28a745);">
                    <h5 class="mb-0 text-white fw-semibold">
                        <i class="bi bi-people-fill me-2"></i>Ayo Bergabung!
                    </h5>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-center text-center gap-3">
                    <p class="text-muted mb-0">Daftarkan diri Anda untuk ikut serta dalam pendataan potensi budidaya masyarakat.</p>
                    <a href="{{ route('register') }}" class="btn btn-success btn-lg rounded-pill px-4">
                        <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                    </a>
                    <hr class="my-1">
                    <p class="text-muted mb-0">Lihat peta sebaran budidaya yang sudah terdaftar:</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    var ctx = document.getElementById('statistikChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Perikanan', 'Aquaponik', 'TOGA'],
            datasets: [{
                label: 'Jumlah Budidaya',
                data: [12, 19, 8],
                backgroundColor: ['#28a745', '#17a2b8', '#ffc107'],
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0f0f0' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush