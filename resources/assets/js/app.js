require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);
Vue.component('example', require('./components/Example.vue'));

const routes = [
  {
    path: '/',
  },
]

const router = new VueRouter({
  mode: 'history',
  routes
})

const app = new Vue({ router }).$mount('#app')
