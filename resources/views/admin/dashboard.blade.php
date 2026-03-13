@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Warga</h5>
                <h2>{{ $totalWarga }}</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Rumah</h5>
                <h2>{{ $totalRumah }}</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Total Budidaya</h5>
                <h2>{{ $totalBudidaya }}</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Warga Aktif</h5>
                <h2>{{ $wargaDenganBudidaya }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Statistik Budidaya per Kategori</h5>
            </div>
            <div class="card-body">
                <canvas id="kategoriChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Distribusi Budidaya</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($budidayaPerKategori as $kategori)
                        <tr>
                            <td>{{ $kategori->nama_kategori }}</td>
                            <td>{{ $kategori->budidayas_count }}</td>
                            <td>
                                @if($totalBudidaya > 0)
                                    {{ round(($kategori->budidayas_count / $totalBudidaya) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var ctx = document.getElementById('kategoriChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($budidayaPerKategori->pluck('nama_kategori')) !!},
            datasets: [{
                data: {!! json_encode($budidayaPerKategori->pluck('budidayas_count')) !!},
                backgroundColor: [
                    '#28a745',
                    '#17a2b8',
                    '#ffc107'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush