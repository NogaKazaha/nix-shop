<template>
  <div class="nav">
      <nav>
        <span id="span"><a href="./">Home</a> /</span>
        <span><a href="./cart">Cart</a></span>
     </nav>
  </div>
  <div class="cart-listing-section">
    <h1>This is your cart</h1>
    <CartCard
			v-for="cart in cart"
			:key="cart.id"
			:cart="cart"
		/>
    <p>Total price:....................................{{this.$store.state.totalPrice + '$'}}</p>
    <p>Total amount:....................................{{this.$store.state.totalAmount}}</p>
    <form method="POST" class="login-inputs">
      <input class="logout-btn" type="submit" value="Cancel" name="remove" />
      <input class="logout-btn" type="submit" value="Go to payment" name="pay" />
    </form>
  </div> 
</template>

<style>
@import "../assets/styles/style.css";
</style>

<script>
import axios from 'axios';
import CartCard from '@/components/CartCard.vue'

export default {
  name: "Cart",
  components: {
    CartCard,
  },
	data() {
		return {
			cart: null,
      totalPrice: 0
		}
	},
  async mounted() {
    this.$store.state.userId = localStorage.getItem('userId')
    this.$store.state.username = localStorage.getItem('username')
    const api = {
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
      url: `http://127.0.0.1:8000/cart/user/${this.$store.state.userId}`,
      }
      const cart = await axios.get(api.url, {
        headers: api.headers,
      })
      const json = await cart.data
      this.cart = json
      console.log(json)
      let newTotalPrice = 0
      let newTotalAmount = 0
      json.forEach(element => {
        const price = parseInt(element.price.replace('$', ''))
        const amount = parseInt(element.amount)
        newTotalPrice += price * amount
        newTotalAmount += amount
        console.log(price)
        console.log(amount)
      });
      console.log(newTotalPrice)
      this.$store.state.totalPrice = newTotalPrice
      this.$store.state.totalAmount = newTotalAmount  
  }
}
</script>