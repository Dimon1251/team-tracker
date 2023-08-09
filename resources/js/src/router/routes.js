import Home from "../pages/Home.vue";
import Login from "../pages/Login.vue";
import Signup from "../pages/Signup.vue";
import Dragable from "../pages/Dragable.vue";

const routes = [
    {
        path: '/',
        component: Home,
    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '/signup',
        component: Signup
    },
    {
        path: '/dragable',
        component: Dragable
    },
];

export default routes;
