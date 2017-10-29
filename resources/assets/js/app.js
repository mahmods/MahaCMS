import Vue from 'vue'
import VueRouter from 'vue-router'
import router from './router'
import Auth from './store/Auth'

import App from './components/app'

Vue.use(VueRouter)
Vue.use(Auth)

const app = new Vue({
    el: '#root',
    template: '<app></app>',
    components: { App },
    router
})