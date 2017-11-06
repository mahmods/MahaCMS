
import VueRouter from 'vue-router'
import DashboardRoute from './dashboard'
import { api_token } from '../store/Auth'

const routes = [];

const router = new VueRouter({
    mode: 'history',
    routes: routes.concat(DashboardRoute)
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth) && !api_token) {
      next({ path: '/dashboard/login', query: { redirect: to.fullPath }});
    } else {
      next();
    }
  });

export default router;