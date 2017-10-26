import Vue from 'vue'
import VueRouter from 'vue-router'
import router from './router'

import App from './components/app'

Vue.use(VueRouter)

const app = new Vue({
    el: '#root',
    template: '<app></app>',
    components: { App },
    router
})