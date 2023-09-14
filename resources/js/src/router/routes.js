import Login from "../pages/Login.vue";
import Signup from "../pages/Signup.vue";
import Settings from "../pages/Settings.vue";
import Projects from "../pages/Projects.vue";
import Board from "../pages/Board.vue";

const routes = [
    {
        path: '/settings',
        component: Settings,
        name: 'settings'
    },
    {
        path: '/projects',
        component: Projects,
        name: 'projects'
    },
    {
        path: '/sprints/:id',
        component: Board,
        name: 'board'
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
        path: '/',
        redirect: '/projects'
    },
    {
        path: '/:catchAll(.*)',
        name: '404',
        redirect: '/',
    },
];

export default routes;
