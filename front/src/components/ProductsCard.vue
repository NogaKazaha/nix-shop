<template v-if="product">
	<div class="product">
      <div class="image-box">
        <div class="images" v-bind:style = "cssProps"></div>
      </div>
      <div class="text-box">
        <h2 class="item">{{product.name}}</h2>
        <h3 class="price">{{product.price}}</h3>
        <p class="description">{{product.status}}</p>
        <p class="description">{{product.amount}}</p>
        <router-link :to="{ name: 'Product card', params: { id: product.id } }"><button type="button">Open product</button></router-link>
      </div>
  </div>
</template>

<style>
@import "../assets/styles/style.css";
</style>

<script>
export default {
	name: 'ProductsCard',
	props: {
		product: {
			type: Object,
		},
	},
  data() {
    return {
      cssProps: {
        backgroundImage: `url(${this.product.photo})`
      }
    }
  }
}
</script>