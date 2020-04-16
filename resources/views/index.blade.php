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
        <div class="d-flex align-items-center result" v-bind:class="{hidden: isHidden}" v-if="isStreaming == true">
            <div class="border-success thumbnail" style="margin-right: 10px;margin-left: 10px;padding-right: 5px;padding-left: 5px;">
                <img loading="lazy" v-bind:src="thumbnail" />
            </div>
            <div class="d-flex flex-column content">
                <strong class="title" style="margin-bottom: 5px;">
                    @{{ title }}
                    <br />
                </strong>
                <small class="artist">
                    Ca sĩ thể hiện:
                    <span style="margin-left: 10px;">
                        @{{ artist }}
                        <br />
                    </span>
                </small>
                <small class="duration">
                    Thời gian:&nbsp;
                    <span>@{{ duration }}</span>
                </small>
                <div class="form-group d-flex align-items-center download" style="margin-top: 10px;">
                    <select class="form-control-sm" style="margin-right: 10px;">
                        <optgroup label="Chất lượng">
                            <option v-bind:value="link128Kbps" selected v-if="link128Kbps != null">128 Kbps</option>
                            <option v-bind:value="link320Kbps" v-if="link320Kbps != null">320 Kbps</option>
                            <option v-bind:value="linkLossless" v-if="linkLossless != null">Lossless</option>
                        </optgroup>
                    </select>
                    <button class="btn btn-dark btn-sm" type="button" v-on:click="downloadFile">Download</button>
                </div>
            </div>
            <a href="" class="hidden resultDownload" @click.prevent="preventDownload"></a>
        </div>
    </div>
    <!-- <script src="/assets/js/jquery.min.js"></script> -->
    <script src="{{ asset('static/js/app.js') }}" defer></script>
    <script src="{{ asset('static/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>