@extends('layouts.app')

@section('content')
<div class="container">
    <h1>✏️ Edit Lagu</h1>
    <form action="{{ route('songs.update', $song->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Judul Lagu</label>
            <input type="text" name="judul_lagu" class="form-control" value="{{ $song->judul_lagu }}" required>
        </div>
        <div class="mb-3">
            <label>Penyanyi</label>
            <input type="text" name="penyanyi" class="form-control" value="{{ $song->penyanyi }}" required>
        </div>
        <div class="mb-3">
            <label>Cover Album</label>
            <input type="file" name="album" class="form-control">
            <img src="{{ asset('storage/' . $song->album) }}" width="100">
        </div>
        <div class="mb-3">
            <label>File Musik</label>
            <input type="file" name="musik" class="form-control">
            <audio controls>
                <source src="{{ asset('storage/' . $song->musik) }}" type="audio/mpeg">
            </audio>
        </div>
        <button type="submit" class="btn btn-primary">✔ Simpan Perubahan</button>
    </form>
</div>
@endsection

