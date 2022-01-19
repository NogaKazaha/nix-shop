<template>
  <div class="nav">
      <nav>
        <span id="span"><router-link to="/">Home</router-link>/</span>
        <span><router-link to="/catalog">Products catalog</router-link></span>
      </nav>
  </div>
  <div class="listing-section">
    <ProductsCard
			v-for="product in products"
			:key="product.id"
			:product="product"
		/>
  </div>
</template>

<style>
@import "../assets/styles/style.css";
</style>

<script>
import axios from 'axios';
import ProductsCard from '@/components/ProductsCard.vue'

export default {
    name: 'Catalog',
    components: {
      ProductsCard,
    },
    data() {
      return {
        products: null,
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
        url: `http://127.0.0.1:8000/products`,
        }
        const productsList = await axios.get(api.url, {
          headers: api.headers,
        })
        const json = await productsList.data
        this.products = json
    },
}
</script>