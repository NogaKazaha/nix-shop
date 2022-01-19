<template>
    <div class="container">
        <div class="header">
            <div class="logo">
                <p>SPACEMART</p>
            </div>
            <div class="h-menu">
              <router-link to="/catalog">Products</router-link>
              <router-link v-if="this.$store.state.userId != null" to="/account">Account</router-link>
              <router-link v-else to="/login">Sign in</router-link>
              <router-link to="/cart">My cart</router-link>
            </div>
            <div class="h-search">
                <input type="text" id="h-input" placeholder="Search">
                <label for="h-input"></label>
            </div>
            <div class="h-phone">
                <p>Phone: +8-800-555-35-35</p>
            </div>
        </div>
    </div>
    <router-view />
</template>

<style>
@import "./assets/styles/style.css";
</style>
