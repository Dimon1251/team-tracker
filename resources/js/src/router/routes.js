import Login from "../pages/Login.vue";
import Signup from "../pages/Signup.vue";
import Settings from "../pages/Settings.vue";
import Home from "../pages/Home.vue";

const routes = [
    {
        path: '/',
        component: Home,
        name: 'home'
    },
    {
        path: '/settings',
        component: Settings,
        name: 'settings'
    },
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
    {
        path: '/signup',
        component: Signup,
        name: 'signup'
    },
    {
        path: '/:catchAll(.*)',
        name: '404',
        redirect: '/',
    },
];

export default routes;
