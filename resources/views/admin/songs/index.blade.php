@extends('layouts.app')

@section('content')
<div class="container">
    <h1>🎵 Daftar Lagu</h1>
    <a href="{{ route('songs.create') }}" class="btn btn-primary">➕ Tambah Lagu</a>

    <table class="table table-dark mt-3">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Penyanyi</th>
                <th>Album</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($songs as $song)
            <tr>
                <td>{{ $song->judul_lagu }}</td>
                <td>{{ $song->penyanyi }}</td>
                <td><img src="{{ asset('storage/' . $song->album) }}" width="50"></td>
                <td>
                    <a href="{{ route('songs.edit', $song->id) }}" class="btn btn-warning">✏️ Edit</a>
                    <form action="{{ route('songs.destroy', $song->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">🗑 Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
