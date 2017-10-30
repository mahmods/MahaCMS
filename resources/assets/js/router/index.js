
import VueRouter from 'vue-router'
import DashboardRoute from './dashboard'

const routes = [];

const router = new VueRouter({
    mode: 'history',
    routes: routes.concat(DashboardRoute)
})

export default router;