<template>
  <div class="nav">
  <nav>
    <span id="span"><router-link to="/">Home</router-link>/</span>
    <span id="span"><router-link to="/account">Account</router-link></span>
  </nav>
  </div>
  <div class="account-container">
    <h1>Hello {{ this.$store.state.username }}</h1>
    <form method="POST" v-on:submit.prevent>
      <input class="logout-btn" type="submit" value="Logout" name="logout" @click="logout()" />
    </form>
  </div>
</template>

<style>
@import "../assets/styles/style.css";
</style>

<script>
export default {
  name: 'Account',
  mounted() {
    if(localStorage.getItem('username') == null || localStorage.getItem('username') == undefined) {
      this.$router.push('Login')
    } else {
      this.$store.state.userId = localStorage.getItem('userId')
      this.$store.state.username = localStorage.getItem('username')
    }
  },
  methods: {
    async logout() {
      this.$store.state.username = null
      this.$store.state.userId = null
      localStorage.removeItem('username')
      localStorage.removeItem('userId')   
      this.$router.push('Login')
    }
  }
}
</script>