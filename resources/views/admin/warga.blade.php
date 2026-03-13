@extends('layouts.admin')

@section('title', 'Data Warga')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Daftar Warga</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="wargaTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Status Rumah</th>
                        <th>Jumlah Budidaya</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wargas as $index => $warga)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $warga->nama }}</td>
                        <td>{{ $warga->email }}</td>
                        <td>{{ $warga->nomor_telepon }}</td>
                        <td>
                            @if($warga->rumah)
                                <span class="badge bg-success">Sudah Mengisi</span>
                            @else
                                <span class="badge bg-warning">Belum Mengisi</span>
                            @endif
                        </td>
                        <td>
                            @if($warga->rumah)
                                {{ $warga->rumah->budidayas->count() }}
                            @else
                                0
                            @endif
                        </td>
                        <td>{{ $warga->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('admin.warga.destroy', $warga->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data warga ini?')">
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
        $('#wargaTable').DataTable();
    });
</script>
@endpush