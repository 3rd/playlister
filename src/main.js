// Imports
import Vue from 'vue'
import VueResource from 'vue-resource'
import VueRouter from 'vue-router'
import VueSweetAlert from 'vue-sweetalert'

// Import loading
Vue.use(VueResource)
Vue.use(VueRouter)
Vue.use(VueSweetAlert)

// My components
import Home from './components/Home'
import About from './components/About'
import PageNotFound from './components/PageNotFound'
import Player from './components/Player'

// eslint-disable-next-line
import Styling from './components/Styling'

// Routing
const routes = [
  { path: '/', component: Home },
  { path: '/about', component: About },
  { path: '/play/:hash', component: Player },
  { path: '*', component: PageNotFound }
]
const router = new VueRouter({
  mode: 'history', // (hash | history | abstract)
  routes: routes
})

// Mount
new Vue({
  router
}).$mount('#app')
