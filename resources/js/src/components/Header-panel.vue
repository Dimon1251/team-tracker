<template>
  <header class="header">
    <div class="logo">
      TeamTracker
    </div>
    <div class="buttons">
      <div class="nav">
        <ul>
          <li>
            <span>Projects</span>
          </li>
          <li>
            <span>My tasks</span>
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
    getAccessToken() {
      if(localStorage.getItem('access_token')) {
        this.$store.state.authorized = true;
      } else {
        this.$store.state.authorized = false;
      }
    },
    getUserData() {
      if (localStorage.getItem('access_token')) {
        api.get('api/users/auth')
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
.header {
  height: 72px;
  width: 100%;
  background-color: white;
  padding: 20px;
  display: flex;
  flex-direction: row;
}
.buttons {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  font-size: 18px;
  margin-left: 20px;
  line-height: 24px;
}
.nav ul, .user {
  display: flex;
  flex-direction: row;
  gap: 15px;
}
.nav ul li {
  cursor: pointer;
}
.logo {
  font-size: 24px;
  font-weight: 600;
  height: 32px;
  padding-top: 3px;
  user-select: none;
}
.name {
  color: gray;
  margin-right: 20px;
}
.info {
  padding: 12px 12px 0;
}
.board {
  padding: 12px;
  display: flex;
  flex-direction: row;
  gap: 12px;
  width: 100%;
}
.block {
  padding: 20px 10px 10px;
  background-color: white;
  border-radius: 20px;
  flex-grow: 1;
  width: calc((100% - 36px) / 4);
}
.block h2 {
  margin-left: 12px;
}
.list-group-item {
  cursor: grab;
//margin: 10px;
  border-radius: 10px;
  padding: 18px;
  background-color: white;
}
.list-group {
  margin-top: 9px;
  width: 100%;
  height: calc(100% - 26px);
  border-radius: 10px;
  padding: 10px;
  background: rgb(226,0,255);
  background: -moz-linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
  background: -webkit-linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
  background: linear-gradient(313deg, rgba(226,0,255,1) 0%, rgba(0,245,255,1) 100%);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e200ff",endColorstr="#00f5ff",GradientType=1);
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.card-header {
  font-weight: 600;
  margin-bottom: 12px;
}
.card-text {
  line-height: 18px;
}
.card-data {
  width: 100%;
  margin-top: 12px;
  display: flex;
  flex-direction: row;
  align-items: end;
}
.card-data span {
  width: 100%;
  text-align: end;
  color: gray;
}
.logout {
  cursor: pointer;
}

</style>
