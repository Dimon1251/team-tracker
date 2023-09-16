<template>
    <div class="wrapper">
        <div class="card">
            <h1>TeamTracker</h1>
            <h2>Email</h2>
            <input class="form_input" type="email" placeholder="Email" v-model="email"/>
            <h2>Password</h2>
            <input class="form_input" type="password" placeholder="Password" v-model="password"/>
            <div class="button" @click="login">
                <div>Login</div>
            </div>
            <div class="link_container">
                <router-link class="link" to="/signup">Sign up</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import router from "../router/router.js";

export default {
    data: function () {
        return {
            email: 'example@test.com',
            password: 'example@test.com',
        }
    },
    methods: {
        login() {
            axios.post('api/login', {
                email: this.email,
                password: this.password,
            }).then( response => {
                if (response.status === 200) {
                    localStorage.setItem('access_token', response.data.token);
                    // localStorage.setItem('refresh_token', response.data.refresh_token);
                    if (localStorage.getItem('access_token')){
                        this.$store.state.authorized = true;
                        router.push('/projects');
                    }
                }
                if (response.status === 422){
                    console.log("Invalid data");
                }
            })
        },
    }
}
</script>
<style>

</style>
