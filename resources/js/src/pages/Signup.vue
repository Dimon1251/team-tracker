<template>
    <div class="wrapper">
        <div class="card">
            <h1>TeamTracker</h1>
            <h2>Email</h2>
            <input class="form_input" type="email" placeholder="Email" v-model="email" />
            <h2>Name</h2>
            <input class="form_input" placeholder="Name" v-model="name" />
            <h2>Password</h2>
            <input class="form_input" type="password" placeholder="Password" v-model="password" />
            <h2>Confirm password</h2>
            <input class="form_input" type="password" placeholder="Confirm password" v-model="confirmPassword" />
            <div class="button" @click="signUp">
                <div>Sign up</div>
            </div>
            <div class="link_container">
                <router-link class="link" to="/login">Log in</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import router from "../router/router.js";
import axios from "axios";
export default {
    data: function () {
        return {
            email: 'example@test.com',
            name: 'Admin',
            password: 'example@test.com',
            confirmPassword: 'example@test.com',
        }
    },
    methods: {
        signUp() {
            axios.post('api/register', {
                email: this.email,
                name: this.name,
                password: this.password,
                password_confirmation: this.confirmPassword
            }).then( response => {
                localStorage.setItem('access_token', response.data.token);
                if (response.status === 200) {
                    localStorage.setItem('access_token', response.data.token);
                    // localStorage.setItem('refresh_token', response.data.refresh_token);
                    if (localStorage.getItem('access_token')){
                        this.$store.state.authorized = true;
                        router.push('/projects');
                    }
                }
            }).catch(error => {
                console.error('Error:', error);
            });
        },
    }
}
</script>
<style>

</style>
