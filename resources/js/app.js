import { createApp } from "vue";
import App from "./src/App.vue";
import Router from "./src/router/router.js";
import Store from "./src/store.js"

const AvaAuth = localStorage.getItem('access_token');
let _LoginUser = null;

if(AvaAuth !== null) {
    _LoginUser = JSON.parse(localStorage.getItem('LoginUser'))
}

createApp(App)
    .use(Router)
    .use(Store)
    .provide('LoginUser', _LoginUser)
    .mount('#app');
