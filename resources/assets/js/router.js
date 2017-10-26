
import VueRouter from 'vue-router'

import CreateForm from './components/forms/create'
import EditForm from './components/forms/edit'
import AccessForm from './components/forms/access'
import ManageForm from './components/forms/manage'
import Login from './components/auth/login'
import Register from './components/auth/register'
import Dashboard from './components/dashboard'
const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/login', component: Login },
        { path: '/register', component: Register },
        {
        	path: '/dashboard', component: Dashboard,
        	children: [
                { path: ':p', component: AccessForm },
                { path: ':p/create', component: CreateForm },
                { path: ':p/:id/update', component: EditForm },
                { path: ':p/manage', component: ManageForm }
        	]
        }
    ]
})

export default router;