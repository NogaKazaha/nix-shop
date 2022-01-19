<template>
  <div class="nav">
  <nav>
    <span id="span"><router-link to="/">Home</router-link>/</span>
    <span id="span"><router-link to="/login">Login</router-link></span>
  </nav>
  </div>
  <div class="login-container">
    <h1>Log me in</h1>
    <form method="POST" class="login-inputs" v-on:submit.prevent>
      <input type="email" name="email" placeholder="Enter your email" />
      <input type="password" name="password" placeholder="Enter your password" />
      <button type="submit" @click="login()">Log in</button>
    </form>
    <span>Don't have account? <router-link to="/sign_up" class="sign-up-btn">Sign up</router-link></span>
  </div>
</template>

<style>
@import "../assets/styles/style.css";
</style>

<script>
import axios from 'axios';

export default {
    name: 'Login',
    mounted() {
      if(localStorage.getItem('username') != null || localStorage.getItem('username') != undefined) {
        this.$router.push('Account')
      }
    },
    methods: {
      async login() {
        const email = document.getElementsByName('email')[0].value
        const password = document.getElementsByName('password')[0].value
        const patern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        const test = patern.test(email)  
        if(test == true) {
          const api = {
            headers: {
              Accept: "application/json",
              "Content-Type": "application/json",
            },
            data: {
              email: email,
              password: password,
            },
            url: `http://127.0.0.1:8000/user/email`,
          }
          const login = await axios.post(api.url, api.data, {
            headers: api.headers,
          })
          const json = await login.data
          this.$store.state.userId = json[0].id
          this.$store.state.username = json[0].username
          localStorage.setItem('username', json[0].username)
          localStorage.setItem('userId', json[0].id)
          this.$router.push('Account')
        }
      }
    },
}
</script>