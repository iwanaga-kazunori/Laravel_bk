<!doctype html>
<html lang="ja">
<head>
<script src="{{ asset('js/feed.js') }}" defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
<div id="app">
    <h2>Feed一覧</h2>
    <div>
        <feed-list></feed-list>
    </div>
</div>
</div>
</body>
</html>
