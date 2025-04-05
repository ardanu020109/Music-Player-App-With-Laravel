<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\SongController;

Route::get('/admin/songs', [SongController::class, 'index'])->name('songs.index');
Route::get('/admin/songs/create', [SongController::class, 'create'])->name('songs.create');
Route::post('/admin/songs', [SongController::class, 'store'])->name('songs.store');
Route::get('/admin/songs/{song}/edit', [SongController::class, 'edit'])->name('songs.edit');
Route::put('/admin/songs/{song}', [SongController::class, 'update'])->name('songs.update');
Route::delete('/admin/songs/{song}', [SongController::class, 'destroy'])->name('songs.destroy');
Route::get('/', [SongController::class, 'showMusicPlayer'])->name('music-player');
Route::get('/api/songs', [SongController::class, 'getSongs']);

