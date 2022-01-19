<template>
  <div class="nav">
  <nav>
    <span id="span"><router-link to="/">Home</router-link>/</span>
    <span id="span"><router-link to="/sign_up">Sign up </router-link></span>
  </nav>
  </div>
  <div class="login-container">
    <h1>Sign me up</h1>
    <form method="POST" class="login-inputs"  v-on:submit.prevent>
      <input type="text" name="username" placeholder="Enter your username" />
      <input type="email" name="email" placeholder="Enter your email" />
      <input type="password" name="password" placeholder="Enter your password" />
      <input type="password" name="pass_conf" placeholder="Enter your password again" />
      <button type="submit" @click="register()">Register</button>
    </form>
    <span>Have an account? <router-link to="/login" class="sign-up-btn">Sign in</router-link></span>
  </div>
</template>

<style>
@import "../assets/styles/style.css";
</style>

<script>
import axios from 'axios';

export default {
    name: 'Sign up.',
    mounted() {
      if(localStorage.getItem('username') != null || localStorage.getItem('username') != undefined) {
        this.$router.push('Account')
      }
    },
    methods: {
      async register() {
        const username = document.getElementsByName('username')[0].value
        const email = document.getElementsByName('email')[0].value
        const password = document.getElementsByName('password')[0].value
        const confirm = document.getElementsByName('pass_conf')[0].value
        const patern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
        const test = patern.test(email)  
        if(test == true && password == confirm) {
          const api = {
            headers: {
              "Content-Type": "application/json",
            },
            data: {
              username: username,
              email: email,
              password: password,
            },
            url: `http://127.0.0.1:8000/user`,
          }
          const reg = await axios.post(api.url, api.data, {
            headers: api.headers,
          })
          const json = await reg.data
          console.log(json)
        }
      }
    },
}
</script>