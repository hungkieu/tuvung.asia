require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

import index from './components/admin/index';
import newStructure from './components/structure_sentences/new';

const routes = [
  {
    path: '/admin',
    component: index,
  },
  {
    path: '/admin/structure_sentences/new',
    component: newStructure,
    name: 'new_structure_sentences'
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
});

const app = new Vue({ router }).$mount('#admin');
