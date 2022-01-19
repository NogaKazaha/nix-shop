<template>
  <div class="nav">
      <nav>
        <span id="span"><router-link to="/">Home</router-link> /</span>
        <span><router-link to="/catalog">Products catalog</router-link> /</span>
        <span><router-link v-if="product" :to="{ name: 'Product card', params: { id: product.id } }">Product</router-link></span>
      </nav>
  </div>
  <div class="listing-section">
      <div class="container-card">
  <div class="card-left">
    <div class="card">
      <h2 v-if="product">{{product.name}}</h2>
    </div>
    <div class="card">
      <img v-if="product" class="cardImg" :src="product.photo">
    </div>
  </div>
  <div class="card-right">
    <p v-if="product" class="p1">{{product.name}}</p>
    <p v-if="product" class="p2">{{product.price}}</p>
    <p v-if="product">{{product.name}} is the latest model of the series of spaceships made by ART company. It is now available only in red color but in the few weeks there will be also blue one and green.</p>
    <form method="POST" class="card-buy" v-on:submit.prevent>
      <p>Amount</p>
      <input type="number" name="quantity" min="1" max="10" step="1" value="1">
      <input v-if="this.$store.state.username != null" class="logout-btn" type="submit" value="Buy" @click="onBuy()" name="buy" />
      <input v-else class="logout-btn" type="submit" value="Login first" name="login-first" disabled/>
    </form>
    <br /> <br /> <br />
    <p class="p1">DELAY: ............................................................................................................... 2 mounth delay</p>
    <p class="p1">Pay: ................................................................................................................... 100% prepaid</p>
    <p class="p1">Full tank</p>
  </div>
  </div>
  <div class="container">
  <div class="footer card-right">
    <div class="logo">
      <p>All rights reserved.</p>
    </div>
    <div class="h-phone">
      <p>Privacy policy</p>
    </div>
  </div>
  </div>
  </div>
</template>

<style>
@import "../assets/styles/style.css";
</style>

<script>
import axios from 'axios';

export default {
  name: "Product card",
  props: {
		id: {
			type: String,
		},
	},
	data() {
		return {
			product: null,
		}
	},
  async mounted() {
      const api = {
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
        },
        url: `http://127.0.0.1:8000/products/${this.id}`,
        }
        const productCard = await axios.get(api.url, {
          headers: api.headers,
        })
        const json = await productCard.data
        this.product = json[0]
        this.$store.state.userId = localStorage.getItem('userId')
        this.$store.state.username = localStorage.getItem('username')
    },
  methods: {
    async onBuy() {
      const amount = document.getElementsByName('quantity')[0].value
      const api = {
        headers: {
          Accept: "application/json",
            "Content-Type": "application/json",
          },
        data: {
          user_id: this.$store.state.userId,
          product_id: this.product.id,
          amount: amount
        },
        url: `http://127.0.0.1:8000/cart`,
      }
      const add = await axios.post(api.url, api.data, {
        headers: api.headers,
      })
      const json = await add.data
      console.log(json)
    }
  }
}
</script>