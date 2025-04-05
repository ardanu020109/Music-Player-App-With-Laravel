<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    public function index()
    {
        $songs = Song::all();
        return view('admin.songs.index', compact('songs'));
    }

    public function create()
    {
        return view('admin.songs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_lagu' => 'required|string|max:255',
            'penyanyi' => 'required|string|max:255',
            'album' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'musik' => 'required|file|mimetypes:audio/mpeg,audio/mp3|max:10240',
        ]);


        // Simpan file album dan musik ke storage
        $albumPath = $request->file('album')->store('albums', 'public');
        $musicPath = $request->file('musik')->store('music', 'public');

        // Simpan data ke database
        Song::create([
            'judul_lagu' => $request->judul_lagu,
            'penyanyi' => $request->penyanyi,
            'album' => $albumPath,
            'musik' => $musicPath,
        ]);

        return redirect()->route('songs.index')->with('success', 'Lagu berhasil ditambahkan!');
    }

    public function edit(Song $song)
    {
        return view('songs.edit', compact('song'));
    }

    public function update(Request $request, Song $song)
    {
        $request->validate([
            'judul_lagu' => 'required|string|max:255',
            'penyanyi' => 'required|string|max:255',
            'album' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'musik' => 'nullable|mimes:mp3,wav|max:10240',
        ]);

        // Jika ada file baru, hapus yang lama dan simpan yang baru
        if ($request->hasFile('album')) {
            Storage::disk('public')->delete($song->album);
            $albumPath = $request->file('album')->store('albums', 'public');
        } else {
            $albumPath = $song->album;
        }

        if ($request->hasFile('musik')) {
            Storage::disk('public')->delete($song->musik);
            $musicPath = $request->file('musik')->store('music', 'public');
        } else {
            $musicPath = $song->musik;
        }

        // Update data lagu
        $song->update([
            'judul_lagu' => $request->judul_lagu,
            'penyanyi' => $request->penyanyi,
            'album' => $albumPath,
            'musik' => $musicPath,
        ]);

        return redirect()->route('songs.index')->with('success', 'Lagu berhasil diperbarui!');
    }

    public function destroy(Song $song)
    {
        // Hapus file dari storage
        Storage::disk('public')->delete($song->album);
        Storage::disk('public')->delete($song->musik);

        // Hapus dari database
        $song->delete();

        return redirect()->route('songs.index')->with('success', 'Lagu berhasil dihapus!');
    }

    public function showMusicPlayer()
    {
        $songs = Song::all();
        if ($songs->isEmpty()) {
            return view('music_player')->with('songs', collect([]));
        };
        return view('music_player', compact('songs')); // Tampilkan ke Blade view
    }

    public function getSongs()
    {
        $songs = Song::all();
        return response()->json($songs);
    }
}
