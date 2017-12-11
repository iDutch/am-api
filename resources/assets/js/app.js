
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var axios = require('axios');

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
};


axios.get('/api/user')
    .then(response => {
        console.log(response.data);
    });

axios.get('/api/schedules')
    .then(response => {
        console.log(response.data);
    });