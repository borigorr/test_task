import App from "./App.vue";
import Users from "./App/Pages/Users.vue";
import {createWebHistory, createRouter} from 'vue-router'
import Error404 from "./App/Pages/Error404.vue";
import Login from "./App/Pages/Login.vue";
import Edit from "./App/Pages/Edit.vue";


const routes = [
    {
        path: '/',
        name: 'login',
        component: Login
    },
    {
        path: '/users',
        name: 'users',
        component: Users
    },
    {
        path: '/users/:id',
        name: 'edit',
        component: Edit
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'Error404',
        component: Error404,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
