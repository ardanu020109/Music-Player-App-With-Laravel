@extends('layouts.app')

@section('content')
<div class="container">
    <h1>➕ Tambah Lagu</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="judul_lagu">Judul Lagu</label>
            <input type="text" name="judul_lagu" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="penyanyi">Penyanyi</label>
            <input type="text" name="penyanyi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="album">Cover Album</label>
            <input type="file" name="album" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="musik">File Musik</label>
            <input type="file" name="musik" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">✔ Simpan</button>
    </form>
</div>
@endsection
