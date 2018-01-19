import './bootstrap';

Vue.component('flash', require('./components/Flash.vue'));

Vue.component('thread-view', require('./pages/Thread.vue'));

const app = new Vue({
    el: '#app'
});
