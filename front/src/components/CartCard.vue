<template>
  <div class="cart-product">
    <img class="cardImg" :src="cart.photo">
    <p>Name of product:....................................{{cart.name}}</p>
    <p>Price of product:....................................{{cart.price}}</p>
    <p>Amount:....................................{{cart.amount}}</p>
  </div>
</template>

<style>
@import "../assets/styles/style.css";
</style>

<script>
export default {
	name: 'CartCard',
	props: {
		cart: {
			type: Object,
		},
	},
}
</script>