/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.FileSaver = require('file-saver');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('result-component', require('./components/ZingResultComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const GET_STREAMING = 0;
const GET_LYRIC = 1;

var app = new Vue({
    el: '#app',
    data: {
        isHidden: true,
        isStreaming: true,
        title: 'Tieu de',
        artist: 'Nghe si',
        thumbnail: 'thumbnail',
        duration: '02:30',
        link128Kbps: null,
        link320Kbps: null,
        linkLossless: null
    },
    methods: {
        submit: function () {
            let group = document.querySelector('option[selected]').parentElement.label;
            let opt = document.querySelector('option[selected]').value;
            let url = document.querySelector('input[class="url"]').value;

            if (group === "Zing MP3") {
                handleZingMp3(opt, url, response => {
                    {
                        if (response['data'].hasOwnProperty('title')) {
                            this.title = response['data'].title;
                        }
                        if (response['data'].hasOwnProperty('artist')) {
                            this.artist = response['data'].artist;
                        }
                        if (response['data'].hasOwnProperty('thumbnail')) {
                            this.thumbnail = response['data'].thumbnail;
                        }
                        if (response['data'].hasOwnProperty('duration')) {
                            this.duration = secondToTime(response['data'].duration);
                        }
                        if (response['data'].hasOwnProperty('links')) {
                            if (response['data']['links'].hasOwnProperty('128') && response['data']['links']['128'].length > 0) {
                                this.link128Kbps = response['data']['links']['128'];
                            }
                            if (response['data']['links'].hasOwnProperty('320') && response['data']['links']['320'].length > 0) {
                                this.link320Kbps = response['data']['links']['320'];
                            }
                            if (response['data']['links'].hasOwnProperty('lossless') && response['data']['links']['lossless'].length > 0) {
                                this.linkLossless = response['data']['links']['lossless'];
                            }
                        }
                        if (this.isHidden == true) {
                            this.isHidden = false;
                        }
                        this.isStreaming = true;
                    }
                });
            }
        },

        downloadFile: function () {
            let url = document.querySelector('.download option[selected]').value;
            FileSaver.saveAs(url, getFileName(url));
        }
    }
});

var handleZingMp3 = function (option, url, callback) {

    let getStreaming = function (url) {
        axios({
            url: 'api/song/download',
            method: 'get',
            baseURL: window.location.href,
            params: {
                url: url
            }
        }).then(response => {
            callback(response['data']);
        });
    }

    let getLyric = function (url) { }

    switch (parseInt(option, 10)) {
        case GET_STREAMING:
            return getStreaming(url);
        case GET_LYRIC:
            return getLyric(url);
    }
}

var getFileName = function(url) {
    let namePattern = /https:\/\/.+\/(.+\.m4a).+filename=(.*\..{0,3})/g;
    let matches = namePattern.exec(url);
    if (matches.length > 2) {
        return matches[2];
    }
    return matches[1];
}

var secondToTime = function(second) {
    time = '';
    if (second > 3600) {
        // Time format hh:mm:ss
        var hh = standardizedTime(parseInt(second/3600, 10));
        var mm = standardizedTime(parseInt((second - hh*3600)/60, 10));
        var ss = standardizedTime(parseInt(second - hh*3600 - mm*60, 10));
        time = time + hh + ':' + mm + ':' + ss;
    } else {
        // Time format mm:ss
        var mm = standardizedTime(parseInt(second/60, 10));
        var ss = standardizedTime(parseInt(second - mm*60, 10));
        time = time + mm + ':' + ss;
    }
    return time;
}

var standardizedTime = function(time) {
    var reverseString = function(str) {
        return ('' + str).split("").reverse().join("");
    }
    var r_time = (reverseString(time) + '00').substring(0, 2);
    return reverseString(r_time);
}