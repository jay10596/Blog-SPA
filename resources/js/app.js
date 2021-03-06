import Vue from 'vue';
import router from './router/router';
import App from './components/App';

import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'

import User from './helpers/user.js';
window.User = User

import Exception from './helpers/exception.js';
window.Exception = Exception

window.EventBus = new Vue();

require('./bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router
});
