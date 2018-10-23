require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);
import VuePaginate from 'vue-paginate'
Vue.use(VuePaginate);

import index from './components/admin/index';
import newStructure from './components/structure_sentences/new';
import indexUsers from './components/admin/users/index';
import indexVocabularies from './components/admin/vocabularies/index';

const routes = [
  {
    path: '/admin',
    component: index,
  },
  {
    path: '/admin/structure_sentences/new',
    component: newStructure,
    name: 'new_structure_sentences'
  },
  {
    path: '/admin/users',
    component: indexUsers,
    name: 'admin_users',
  },
  {
    path: '/admin/vocabularies',
    component: indexVocabularies,
    name: 'admin_vocabularies',
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
});

const app = new Vue({ router }).$mount('#admin');
