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
.wrapper {
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card {
    padding: 30px;
    background-color: white;
    border-radius: 20px;
    width: 500px;
    margin: 10px;
}
h1 {
    font-size: 24px;
    font-weight: 600;
    width: 100%;
    text-align: center;
    margin-bottom: 16px;
}
h2 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 8px;
}
.form_input {
    width: 100%;
    height: 36px;
    border-radius: 6px;
    border: 1px solid #a0aec0;
    padding: 0 9px;
    margin-bottom: 21px;
}
.button {
    height: 40px;
    padding: 2px;
    background: rgba(226,0,255, 1);
    background: -moz-linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
    background: -webkit-linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
    background: linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e200ff",endColorstr="#00f5ff",GradientType=1);
    border-radius: 6px;
    cursor: pointer;
    margin: 10px 0;
}

.button div {
    background-color: white;
    padding: 0 20px;
    height: 100%;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    user-select: none;
}
.button:active div {
    background-color: rgba(255,255,255, 0.8);
}
.link_container {
    display: flex;
    flex-direction: row;
    justify-content: end;
    margin-top: 16px;
}
.link {
    color: black;
}
</style>
