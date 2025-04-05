<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #111;
            color: white;
        }
        .container {
            margin-top: 20px;
        }
        .navbar {
            background-color: #222;
        }
        .navbar-brand {
            color: red;
            font-weight: bold;
        }
        .playlist {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .song-item {
            background: #222;
            padding: 10px;
            margin: 10px;
            border-radius: 8px;
            text-align: center;
            width: 200px;
        }
        .song-item img {
            width: 100%;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('songs.index') }}">🎵 Admin Panel</a>
            <a class="navbar-brand" href="/">🎧 Music Player</a>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
