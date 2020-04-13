<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>KingCrawler - Crawl Everything</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/untitled.css') }}">
</head>

<body>
    <div class="header"><img src="{{ asset('img/logo.png') }}">
        <ul class="text-monospace navbar">
            <li><a class="text-dark item-menu" href="#">ZingMP3</a></li>
            <li><a class="text-dark item-menu" href="#">NCT</a></li>
            <li><a class="text-dark item-menu" href="#">Youtube</a></li>
            <li><a class="text-dark item-menu" href="#">Google Drive</a></li>
        </ul>
    </div>
    <div class="container d-sm-flex flex-column justify-content-sm-start main">
        <h4 class="text-center">Nhập đường dẫn</h4>
        <div class="form-group d-sm-flex justify-content-center justify-content-sm-center"><select class="type"><optgroup label="This is a group"><option value="12" selected="">This is item 1</option><option value="13">This is item 2</option><option value="14">This is item 3</option></optgroup></select><input type="url" class="url"
                name="url" autofocus="" autocomplete="off" required=""><button class="btn btn-dark btn-sm" type="button">Crawl</button></div>
        <div class="result">
            <h5>Kết quả:</h5>
            <ul class="list-group">
                <li class="list-group-item"><span>Item 1</span></li>
                <li class="list-group-item"><span>Item 2</span></li>
                <li class="list-group-item"><span>Item 3</span></li>
                <li class="list-group-item"><span>Item 4</span></li>
                <li class="list-group-item"><span>Item 5</span></li>
            </ul>
        </div>
    </div>
    <!-- <script src="/assets/js/jquery.min.js"></script> -->
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>