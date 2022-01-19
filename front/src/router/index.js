import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/components/Home.vue'
import Login from '@/components/Login.vue'
import Registration from '@/components/Registration.vue'
import Account from '@/components/Account.vue'
import Products from '@/components/Products.vue'
import Card from '@/components/Card.vue'
import Cart from '@/components/Cart.vue'

export default createRouter({
	history: createWebHistory(),
	routes: [
		{
			path: '/',
			name: 'Home',
			component: Home,
		},
    {
			path: '/login',
			name: 'Login',
			component: Login,
		},
    {
			path: '/sign_up',
			name: 'Sign Up',
			component: Registration,
		},
    {
			path: '/account',
			name: 'Account',
			component: Account,
		},
    {
			path: '/catalog',
			name: 'Products catalog',
			component: Products,
		},
		{
			path: '/card/:id',
			props: true,
			name: 'Product card',
			component: Card,
		},
		{
			path: '/cart',
			name: 'My cart',
			component: Cart,
		},
	],
})