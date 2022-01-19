<template>
  <div class="nav">
  <nav>
    <span id="span"><router-link to="/">Home</router-link></span>
  </nav>
</div>
<div class="home-container">
  <h1>Want to find new spaceship for your needs?</h1>
  <img class="market-img" src="/images/market.jpg" alt="Market">
  <p class="home-info">Here you can find anything you want for any of your needs</p>
  <p><router-link class="search-btn" to="/catalog">Inspect new ships</router-link> or <router-link v-if="this.$store.state.userId == null" class="search-btn" to="/login">Login</router-link>
  <router-link v-else class="search-btn" to="/account">Account</router-link></p>
</div>
</template>

<style scoped>
@import "../assets/styles/style.css";
</style>

<script>
export default {
  mounted() {
    this.$store.state.userId = localStorage.getItem('userId')
    this.$store.state.username = localStorage.getItem('username')
  }
}
</script>
