@extends('layouts.admin')

@section('title', 'Data Budidaya')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Daftar Budidaya</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="budidayaTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pemilik</th>
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
                        <td>{{ $budidaya->rumah->user->nama }}</td>
                        <td>
                            <span class="badge bg-{{ $budidaya->kategori->nama_kategori == 'Perikanan' ? 'primary' : ($budidaya->kategori->nama_kategori == 'Aquaponic' ? 'info' : 'warning') }}">
                                {{ $budidaya->kategori->nama_kategori }}
                            </span>
                        </td>
                        <td>{{ $budidaya->nama_budidaya }}</td>
                        <td>{{ $budidaya->jumlah }}</td>
                        <td>{{ $budidaya->satuan }}</td>
                        <td>
                            <form action="{{ route('admin.budidaya.destroy', $budidaya->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data budidaya ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#budidayaTable').DataTable();
    });
</script>
@endpush