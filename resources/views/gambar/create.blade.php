@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Unggah File</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('gambar.store') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama File</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Pilih File</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Unggah</button>
    </form>
@endsection
