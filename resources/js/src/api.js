import axios from "axios";
import store from './store';
import router from "./router/router.js";

const api = axios.create();

api.interceptors.request.use( config => {
    if (localStorage.getItem('access_token')) {
        config.headers.authorization = `Bearer ${localStorage.getItem('access_token')}`
    }
    return config
}, error => {
});

api.interceptors.response.use( config => {
    if (localStorage.getItem('access_token')) {
        config.headers.authorization = `Bearer ${localStorage.getItem('access_token')}`
    }
    return config
}, error => {
    console.log(error)
    if (error.response.status === 401) {
    //     return axios.get('http://46.150.0.33:5050/api/refresh_token', {
    //         headers: {
    //             'authorization' : `Bearer ${localStorage.getItem('refresh_token')}`
    //         }
    //     }).then( response => {
    //         if (response.data.status === 'success') {
    //             localStorage.setItem('access_token', response.data.authorisation.token);
    //             if (localStorage.getItem('access_token')) {
    //                 store.state.authorized = true;
    //             }
    //         } else {
    //             store.state.authorized = false;
    //             localStorage.setItem('access_token', '');
    //         }
    //     }).catch(error => {
    //         if (error.response.data.detail === 'Refresh token expired') {
    //             store.state.authorized = false;
    //             localStorage.setItem('access_token', '');
    //             localStorage.setItem('refresh_token', '');
    //         }
    //     });
    // } else {
        localStorage.setItem('access_token', '');
        this.$store.state.authorized = false;
        router.push('/login');
    }
});

export default api;
