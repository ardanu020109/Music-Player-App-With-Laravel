<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
        }

        .music-player {
            background: #1e1e1e;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.2);
            display: inline-block;
            text-align: center;
            width: 500px;
        }

        #song-title {
            margin-top: 25px;
        }

        #album-cover {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            margin: auto;
            position: relative;
            overflow: hidden;
            transition: transform 1s;
        }

        @keyframes spinGrow {
            0% {
                transform: rotate(0deg) scale(1);
            }

            50% {
                transform: rotate(180deg) scale(1.2);
            }

            100% {
                transform: rotate(360deg) scale(1);
            }
        }

        #progress-bar {
            appearance: none;
            width: 100%;
            height: 8px;
            border-radius: 5px;
            background: #333;
        }

        .btn {
            border-radius: 50px;
            padding: 10px 15px;
            font-size: 18px;
        }

        .btn-primary {
            background-color: #ff6600;
            border: none;
        }

        .btn-danger {
            background-color: #cc0000;
        }

        .modal-content {
            background: #1e1e1e;
            color: white;
        }

        .list-group-item {
            background: #333;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container text-center mt-5">
        <h1>🎙 Music Player</h1>
        <div class="music-player">
            @if ($songs->isNotEmpty())
                <img id="album-cover" src="{{ asset('storage/' . $songs->first()->album) }}">
                <div class="row justify-content-center">
                    <strong id="song-title">{{ $songs->first()->judul_lagu }}</strong>
                    <p id="song-artist">{{ $songs->first()->penyanyi }}</p>
                </div>
                <audio id="main-audio" src="{{ asset('storage/' . $songs->first()->musik) }}"
                    ontimeupdate="updateProgress()" style="display: none;"></audio>
            @else
                <img id="album-cover" src="{{ asset('images/default_album.png') }}">
                <p id="song-title">Tidak ada lagu tersedia</p>
                <audio id="main-audio" ontimeupdate="updateProgress()" style="display: none;"></audio>
            @endif

            <progress id="progress-bar" value="0" max="100"></progress>

            <div class="mt-3">
                <button class="btn btn-secondary" onclick="prevSong()">⏮</button>
                <button class="btn btn-primary" id="play-pause-btn" onclick="togglePlay()">▶</button>
                <button class="btn btn-secondary" onclick="nextSong()">⏭</button>
                <button class="btn btn-danger" onclick="stopSong()">⏹</button>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#songModal">Pilih Lagu</button>
    </div>

    <div class="modal fade" id="songModal" tabindex="-1" aria-labelledby="songModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="songModalLabel">Daftar Lagu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group" id="song-list">
                        @forelse ($songs as $song)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $song->judul_lagu }} - {{ $song->penyanyi }}
                                <button class="btn btn-sm btn-success"
                                    onclick="changeSong('{{ asset('storage/' . $song->musik) }}', '{{ asset('storage/' . $song->album) }}', '{{ $song->judul_lagu }}', '{{ $song->penyanyi }}')">Putar</button>
                            </li>
                        @empty
                            <li class="list-group-item text-center">Tidak ada lagu tersedia</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        let audioPlayer = document.getElementById("main-audio");
        let progressBar = document.getElementById("progress-bar");
        let albumCover = document.getElementById("album-cover");
        let songTitle = document.getElementById("song-title");
        let songArt = document.getElementById("song-artist");
        let playPauseBtn = document.getElementById("play-pause-btn");
        let songList = @json($songs);
        let currentIndex = 0;

        function updateProgress() {
            progressBar.value = (audioPlayer.currentTime / audioPlayer.duration) * 100;
        }

        function changeSong(src, album, title, artist) {
            audioPlayer.pause();
            audioPlayer.currentTime = 0;
            audioPlayer.src = src;
            albumCover.src = album;
            songTitle.innerText = title;
            songArt.innerText = artist;
            audioPlayer.load();
            audioPlayer.play();
            playPauseBtn.innerHTML = "⏸";
            albumCover.style.animation = "spinGrow 5s infinite";
        }

        function togglePlay() {
            if (audioPlayer.paused) {
                audioPlayer.play();
                playPauseBtn.innerHTML = "⏸";
            } else {
                audioPlayer.pause();
                playPauseBtn.innerHTML = "▶";
            }
        }

        function stopSong() {
            audioPlayer.pause();
            audioPlayer.currentTime = 0;
            playPauseBtn.innerHTML = "▶";
        }

        function prevSong() {
            currentIndex = (currentIndex - 1 + songList.length) % songList.length;
            playSongAtIndex(currentIndex);
        }

        function nextSong() {
            currentIndex = (currentIndex + 1) % songList.length;
            playSongAtIndex(currentIndex);
        }

        function playSongAtIndex(index) {
            let song = songList[index];
            changeSong("{{ asset('storage/') }}/" + song.musik, "{{ asset('storage/') }}/" + song.album, song.judul_lagu,
                song.penyanyi);
        }

        audioPlayer.addEventListener("ended", function() {
            nextSong();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
