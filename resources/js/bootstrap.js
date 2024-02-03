window._ = require('lodash');

    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';




import Vue from 'vue';

import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: "95d0bd1bc3064797f3c9",
    cluster: "95d0bd1bc3064797f3c9",
    wsHost:window.location.hostname,
    wsPort:6001,
    forceTLS: false

});

