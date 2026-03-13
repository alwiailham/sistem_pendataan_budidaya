@extends('layouts.app')

@section('title', 'Data Budidaya')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('rumah.index') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-house-door"></i> Data Rumah
            </a>
            <a href="{{ route('budidaya.index') }}" class="list-group-item list-group-item-action active">
                <i class="bi bi-tree"></i> Data Budidaya
            </a>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Budidaya Saya</h5>
                <a href="{{ route('budidaya.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus"></i> Tambah Budidaya
                </a>
            </div>
            <div class="card-body">
                @if($budidayas->isEmpty())
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        Anda belum memiliki data budidaya. Silakan <a href="{{ route('budidaya.create') }}" class="alert-link">tambah budidaya</a>.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Nama Budidaya</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($budidayas as $index => $budidaya)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge bg-{{ $budidaya->kategori->nama_kategori == 'Perikanan' ? 'primary' : ($budidaya->kategori->nama_kategori == 'Aquaponic' ? 'info' : 'warning') }}">
                                            {{ $budidaya->kategori->nama_kategori }}
                                        </span>
                                    </td>
                                    <td>{{ $budidaya->nama_budidaya }}</td>
                                    <td>{{ $budidaya->jumlah }}</td>
                                    <td>{{ $budidaya->satuan }}</td>
                                    <td>
                                        <a href="{{ route('budidaya.edit', $budidaya->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('budidaya.destroy', $budidaya->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection