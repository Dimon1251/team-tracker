import {createRouter, createWebHistory} from "vue-router";
import routes from "./routes.js";

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach( (to, from, next) => {
    const accessToken = localStorage.getItem('access_token');
    if (to.name === 'login' || to.name === 'signup') {
        if(accessToken) {
            return next({
                name: 'home'
            })
        }
    }
    if (to.name === 'home' && !accessToken) {
        return next({
            name: 'login'
        })
    }

    next();
})

export default router;
