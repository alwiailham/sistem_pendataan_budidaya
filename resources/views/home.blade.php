@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="row">
    <div class="col-md-12 text-center mb-4">
        <h1 class="display-4">Sistem Pendataan Budidaya</h1>
        <p class="lead">Perikanan, Aquaponik, dan Tanaman Obat Keluarga (TOGA)</p>
        <hr class="my-4">
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-fish display-1 text-success"></i>
                <h4 class="mt-3">Perikanan</h4>
                <p>Pendataan budidaya ikan air tawar seperti lele, nila, gurame, dan lainnya.</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-water display-1 text-success"></i>
                <h4 class="mt-3">Aquaponik</h4>
                <p>Sistem budidaya tanaman dengan media air yang terintegrasi dengan ikan.</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-flower1 display-1 text-success"></i>
                <h4 class="mt-3">TOGA</h4>
                <p>Tanaman obat keluarga seperti jahe, kunyit, sereh, dan tanaman herbal lainnya.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Statistik Budidaya</h5>
            </div>
            <div class="card-body">
                <canvas id="statistikChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Ayo Bergabung!</h5>
            </div>
            <div class="card-body text-center">
                <p>Daftarkan diri Anda untuk ikut serta dalam pendataan potensi budidaya masyarakat.</p>
                <a href="{{ route('register') }}" class="btn btn-success btn-lg">
                    <i class="bi bi-person-plus"></i> Daftar Sekarang
                </a>
                <hr>
                <p>Atau lihat peta sebaran budidaya yang sudah terdaftar:</p>
                <a href="{{ route('peta.index') }}" class="btn btn-outline-success">
                    <i class="bi bi-map"></i> Lihat Peta
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Statistik chart (contoh data, nanti bisa diambil dari server)
    var ctx = document.getElementById('statistikChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Perikanan', 'Aquaponik', 'TOGA'],
            datasets: [{
                label: 'Jumlah Budidaya',
                data: [12, 19, 8],
                backgroundColor: [
                    '#28a745',
                    '#17a2b8',
                    '#ffc107'
                ]
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush