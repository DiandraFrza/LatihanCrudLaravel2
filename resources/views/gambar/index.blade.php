@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Daftar File</h1>
    <a href="{{ route('gambar.create') }}" class="btn btn-primary mb-3">Unggah File</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
                <tr>
                    <!-- <td>{{ $file->id }}</td> -->
                    <td>{{ $loop->iteration }}
                    <td>{{ $file->nama }}</td>
                    <td>
                        @if(in_array(pathinfo($file->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset('storage/' . $file->file_path) }}" alt="{{ $file->nama }}" class="img-thumbnail" style="width: 100px;">
                        @else
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-info btn-sm">Lihat File</a>
                        @endif
                        <!-- liat -->
                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-info btn-sm">Lihat File</a>
                        <!-- edit -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $file->id }}">Edit</button>
                        <form action="{{ route('gambar.destroy', $file->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>

                        <!-- Modal -->
                        <div class="modal fade" id="editModal{{ $file->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $file->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $file->id }}">Edit File</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('gambar.update', $file->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nama{{ $file->id }}" class="form-label">Nama File</label>
                                                <input type="text" name="nama" id="nama{{ $file->id }}" class="form-control" value="{{ $file->nama }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="file{{ $file->id }}" class="form-label">Ganti File (Opsional)</label>
                                                <input type="file" name="file" id="file{{ $file->id }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
