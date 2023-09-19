<template>
  <header class="header">
    <div class="logo">
      TeamTracker
    </div>
    <div class="buttons">
      <div class="nav">
        <ul>
          <li>
            <router-link class="link" to="/projects">My Projects</router-link>
          </li>
          <li>
            <router-link class="link" to="/tasks">My Tasks</router-link>
          </li>
          <li>
            <router-link class="link" to="/settings">Settings</router-link>
          </li>
        </ul>
      </div>
      <div class="user">
        <div class="name">
          {{ name }}
        </div>
        <div class="logout" @click="logout">
          Logout
        </div>
      </div>
    </div>
  </header>

</template>

<script>

import router from "../router/router.js";
import api from "../api.js";

export default {
  data() {
    return {
      name: null
    }
  },
  methods: {

    logout () {
      localStorage.setItem('access_token', '');
      this.$store.state.authorized = false;
      router.push('/login');
    },
    // getAccessToken() {
    //   if(localStorage.getItem('access_token')) {
    //     this.$store.state.authorized = true;
    //   } else {
    //     this.$store.state.authorized = false;
    //   }
    // },
    getUserData() {
      if (localStorage.getItem('access_token')) {
            api.get('/api/users/auth')
            .then( response => {
              this.name = response.data.User.name;
              this.$store.state.user_email = response.data.User.email;
            })
      }
    }
  },
  mounted() {
    this.getUserData();
  },
  updated() {
    //
  }
}
</script>

<style>


</style>
