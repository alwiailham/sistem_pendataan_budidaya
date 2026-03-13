@extends('layouts.admin')

@section('title', 'Statistik Budidaya')

@section('content')
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Statistik per Kategori</h5>
            </div>
            <div class="card-body">
                <canvas id="kategoriChart"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Top 10 Budidaya Terbanyak</h5>
            </div>
            <div class="card-body">
                <canvas id="topBudidayaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Detail Statistik</h5>
            </div>
            <div class="card-body">
                @php
                    $kategoriStats = App\Models\Kategori::withCount('budidayas')->get();
                    $totalBudidaya = App\Models\Budidaya::count();
                    
                    $topBudidaya = App\Models\Budidaya::select('nama_budidaya', 
                                        \DB::raw('COUNT(*) as total'))
                                    ->groupBy('nama_budidaya')
                                    ->orderBy('total', 'desc')
                                    ->limit(10)
                                    ->get();
                @endphp
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Jumlah Budidaya</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategoriStats as $kategori)
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
</div>
@endsection

@push('scripts')
<script>
    // Chart Kategori
    var ctx1 = document.getElementById('kategoriChart').getContext('2d');
    new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: {!! json_encode($kategoriStats->pluck('nama_kategori')) !!},
            datasets: [{
                data: {!! json_encode($kategoriStats->pluck('budidayas_count')) !!},
                backgroundColor: ['#28a745', '#17a2b8', '#ffc107']
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
    
    // Chart Top Budidaya
    var ctx2 = document.getElementById('topBudidayaChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topBudidaya->pluck('nama_budidaya')) !!},
            datasets: [{
                label: 'Jumlah Budidaya',
                data: {!! json_encode($topBudidaya->pluck('total')) !!},
                backgroundColor: '#28a745'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    });
</script>
@endpush