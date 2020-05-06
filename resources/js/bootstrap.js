window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//jwt Token
const JwtToken = `Bearer ${localStorage.getItem('token')}`
window.axios.defaults.headers.common['Authorization'] = JwtToken;


//Pusher
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'c9a5e8ca8c9d8dfcd906',
    cluster: 'ap4',
    useTLS: true
});
