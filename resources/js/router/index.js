
import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';
import Register from '../pages/Register';
import Login from '../pages/Login';
import Dashboard from '../pages/Dashboard';

import Role from '../pages/roles/Index';
import AddRole from '../pages/roles/AddRole';
import EditRole from '../pages/roles/EditRole';

import User from '../pages/users/Index';
import AddUser from '../pages/users/AddUser';
import EditUser from '../pages/users/EditUser';
//import Posts from '../components/Posts';
//import EditPost from '../components/EditPost';
//import AddPost from '../components/AddPost';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'role',
        path: '/role',
        component: Role
    },
    {
        name: 'addrole',
        path: '/role/add',
        component: AddRole
    },
    {
        name: 'editrole',
        path: '/role/edit/:id',
        component: EditRole
    },
    {
        name: 'user',
        path: '/user',
        component: User
    },
    {
        name: 'adduser',
        path: '/user/add',
        component: AddUser
    },
    {
        name: 'edituser',
        path: '/user/edit/:id',
        component: EditUser
    }
    /*{
        name: 'posts',
        path: '/posts',
        component: Posts
    },
    {
        name: 'addpost',
        path: '/posts/add',
        component: AddPost
    },
    {
        name: 'editpost',
        path: '/posts/edit/:id',
        component: EditPost
    }*/
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
