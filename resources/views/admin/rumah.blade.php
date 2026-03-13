@extends('layouts.admin')

@section('title', 'Data Rumah')

@section('content')
<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Daftar Rumah Warga</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="rumahTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemilik</th>
                        <th>Alamat</th>
                        <th>Koordinat</th>
                        <th>Jumlah Budidaya</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rumahs as $index => $rumah)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $rumah->user->nama }}</td>
                        <td>{{ $rumah->alamat }}</td>
                        <td>{{ $rumah->latitude }}, {{ $rumah->longitude }}</td>
                        <td>{{ $rumah->budidayas->count() }}</td>
                        <td>
                            <form action="{{ route('admin.rumah.destroy', $rumah->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data rumah ini?')">
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
        $('#rumahTable').DataTable();
    });
</script>
@endpush