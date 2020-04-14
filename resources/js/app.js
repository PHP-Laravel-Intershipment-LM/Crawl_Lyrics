/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const GET_STREAMING = 0;
const GET_LYRIC = 1;

const app = new Vue({
    el: '#app',
    methods: {
        submit: function() {
            let group = document.querySelector('option[selected]').parentElement.label;
            let opt = document.querySelector('option[selected]').value;
            let url = document.querySelector('input[class="url"]').value;
            
            if (group === "Zing MP3") {
                handleZingMp3(opt, url);
            }
        }
    }
});

var handleZingMp3 = function(option, url) {

    let getStreaming = function(url) {
        axios({
            url: 'api/song/download',
            method: 'get',
            baseURL: window.location.href,
            params: {
                url: url
            }
        }).then(response => {
            console.log(response);
        })
    }
    let getLyric = function(url) {}

    switch (parseInt(option, 10)) {
        case GET_STREAMING:
            getStreaming(url);
            break;
        case GET_LYRIC:
            getLyric(url);
            break;
    }
}
