import Lodash from 'lodash';
import Vue from 'vue';
import JQuery from 'jquery';
import Axios from 'axios';

window._ = Lodash;
window.Vue = Vue;

Vue.prototype.authorize = function (handler) {
    let user = window.App.user;

    return user ? handler(user) : false;
}

try {
    window.$ = window.jQuery = JQuery;
    require('bootstrap-sass');
} catch (e) {}

window.axios = Axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.events = new Vue();

window.flash = function(message, level = 'success') {
    window.events.$emit('flash', { message, level });
}
