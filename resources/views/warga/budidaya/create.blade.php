@extends('layouts.app')

@section('title', 'Tambah Data Budidaya')

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
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Tambah Data Budidaya</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('budidaya.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori Budidaya</label>
                        <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_budidaya" class="form-label">Nama Budidaya</label>
                        <input type="text" class="form-control @error('nama_budidaya') is-invalid @enderror" 
                               id="nama_budidaya" name="nama_budidaya" value="{{ old('nama_budidaya') }}" required>
                        @error('nama_budidaya')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                       id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="1" required>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <select class="form-select @error('satuan') is-invalid @enderror" 
                                        id="satuan" name="satuan" required>
                                    <option value="">Pilih Satuan</option>
                                    <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                    <option value="ekor" {{ old('satuan') == 'ekor' ? 'selected' : '' }}>Ekor</option>
                                    <option value="tanaman" {{ old('satuan') == 'tanaman' ? 'selected' : '' }}>Tanaman</option>
                                    <option value="polybag" {{ old('satuan') == 'polybag' ? 'selected' : '' }}>Polybag</option>
                                </select>
                                @error('satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <h6>Contoh Pengisian:</h6>
                        <ul class="mb-0">
                            <li>Perikanan: Lele, Nila, Gurame (satuan: kg atau ekor)</li>
                            <li>Aquaponic: Kangkung, Selada, Bayam (satuan: tanaman)</li>
                            <li>TOGA: Jahe, Kunyit, Sereh (satuan: tanaman atau polybag)</li>
                        </ul>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan Data Budidaya</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection