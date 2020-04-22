import Vue from 'vue';
import router from './router/router';
import App from './components/App';

import User from './helpers/user.js';
window.User = User

console.log(User.id());

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
