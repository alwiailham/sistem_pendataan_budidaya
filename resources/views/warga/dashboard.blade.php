@extends('layouts.app')

@section('title', 'Dashboard Warga')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('rumah.index') }}" class="list-group-item list-group-item-action">
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
                <h5 class="mb-0">Selamat Datang, {{ Auth::user()->nama }}!</h5>
            </div>
            <div class="card-body">
                @if(!$rumah)
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        Anda belum mengisi data rumah. Silakan <a href="{{ route('rumah.create') }}" class="alert-link">isi data rumah</a> terlebih dahulu.
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Data Rumah</h6>
                                    <p><strong>Alamat:</strong> {{ $rumah->alamat }}</p>
                                    <p><strong>Koordinat:</strong> {{ $rumah->latitude }}, {{ $rumah->longitude }}</p>
                                    <a href="{{ route('rumah.index') }}" class="btn btn-sm btn-success">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Data Budidaya</h6>
                                    <p><strong>Total Budidaya:</strong> {{ $budidayas->count() }}</p>
                                    @foreach($budidayas->groupBy('kategori.nama_kategori') as $kategori => $items)
                                        <p><strong>{{ $kategori }}:</strong> {{ $items->count() }} jenis</p>
                                    @endforeach
                                    <a href="{{ route('budidaya.index') }}" class="btn btn-sm btn-success">Kelola Budidaya</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($budidayas->isNotEmpty())
                        <h6 class="mt-3">Daftar Budidaya:</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Nama Budidaya</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($budidayas as $index => $budidaya)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $budidaya->kategori->nama_kategori }}</td>
                                        <td>{{ $budidaya->nama_budidaya }}</td>
                                        <td>{{ $budidaya->jumlah }} {{ $budidaya->satuan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection