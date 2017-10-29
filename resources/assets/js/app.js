import Vue from 'vue'
import VueRouter from 'vue-router'
import router from './router'
import Auth from './store/Auth'
import Toasted from 'vue-toasted';

import App from './components/app'

Vue.use(VueRouter)
Vue.use(Auth)
Vue.use(Toasted, {
    position: 'bottom-right',
    duration: '3000',
    theme: 'bubble'
})

const app = new Vue({
    el: '#root',
    template: '<app></app>',
    components: { App },
    router
})