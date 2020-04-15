<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>KingCrawler - Crawl Everything</title>
    <link rel="stylesheet" href="{{ asset('static/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/styles.css') }}">
</head>

<body>
    <div class="header"><img src="{{ asset('static/img/logo.png') }}">
        <ul class="text-monospace navbar">
            <li><a class="text-dark item-menu" href="#">ZingMP3</a></li>
            <li><a class="text-dark item-menu" href="#">NCT</a></li>
            <li><a class="text-dark item-menu" href="#">Youtube</a></li>
            <li><a class="text-dark item-menu" href="#">Google Drive</a></li>
        </ul>
    </div>
    <div class="container d-sm-flex flex-column justify-content-sm-start main" id="app">
        <h4 class="text-center">Nhập đường dẫn</h4>
        <div class="form-group d-sm-flex justify-content-center justify-content-sm-center">
            <select class="type">
                <optgroup label="Zing MP3">
                    <option value="0" selected="">Get streaming</option>
                    <option value="1">Get lyric</option>
                </optgroup>
            </select>
            <input type="url" class="url" name="url" autofocus="" autocomplete="off" required="">
            <button class="btn btn-dark btn-sm" type="button" v-on:click="submit">GET</button>
        </div>
        <result-component ref="resultComponent"></result-component>
    </div>
    <!-- <script src="/assets/js/jquery.min.js"></script> -->
    <script src="{{ asset('static/js/app.js') }}" defer></script>
    <script src="{{ asset('static/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>