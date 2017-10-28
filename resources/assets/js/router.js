
import VueRouter from 'vue-router'

import CreateForm from './components/forms/create'
import EditForm from './components/forms/edit'
import AccessForm from './components/forms/access'
import ManageForm from './components/forms/manage'
import Login from './components/auth/login'
import Register from './components/auth/register'
import Dashboard from './components/dashboard'
import Settings from './components/dashboard/settings'
import Profile from './components/dashboard/profile'
import UsersList from './components/dashboard/users'
import UsersRoles from './components/dashboard/usersRoles'
import RolesList from './components/dashboard/roles'
import RolesPermissions from './components/dashboard/rolesPermissions'
const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/login', component: Login },
        { path: '/register', component: Register },
        {
        	path: '/dashboard', component: Dashboard,
        	children: [
                { path: 'settings', component: Settings },
                { path: 'profile', component: Profile },
                { path: 'users', component: UsersList },
                { path: 'users/:id/roles', component: UsersRoles },
                { path: 'roles', component: RolesList },
                { path: 'roles/:id/permissions', component: RolesPermissions },
                { path: ':p', component: AccessForm },
                { path: ':p/create', component: CreateForm },
                { path: ':p/:id/update', component: EditForm },
                { path: ':p/manage', component: ManageForm },
        	]
        }
    ]
})

export default router;