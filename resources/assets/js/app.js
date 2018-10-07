require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

import index from './components/home/index';
import vocabularies from './components/vocabularies/index';
import newVocab from './components/vocabularies/new';

const routes = [
  {
    path: '/',
    component: index,
  },
  {
    path: '/vocabularies',
    component: vocabularies,
    children: [
    ]
  },
  {
    path: '/vocabularies/new',
    name: 'newVocab',
    component: newVocab,
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

const app = new Vue({ router }).$mount('#app')
