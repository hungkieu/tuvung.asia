require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

import index from './components/home/index';
import vocabularies from './components/vocabularies/index';
import newVocab from './components/vocabularies/new';
import UserProfile from './components/users/show';
import editVocab from './components/vocabularies/edit';
import showVocab from './components/vocabularies/show';

const routes = [
  {
    path: '/',
    component: index
  },
  {
    path: '/vocabularies',
    component: vocabularies,
    children: []
  },
  {
    path: '/vocabularies/new',
    name: 'newVocab',
    component: newVocab
  },
  {
    path: '/user-profile/:id',
    name: 'UserProfile',
    component: UserProfile
  },
  {
    path: '/vocabularies/:id/new',
    name: 'newChildVocab',
    component: newVocab,
  },
  {
    path: '/vocabularies/:id/edit',
    name: 'editVocab',
    component: editVocab,
  },
  {
    path: '/vocabularies/:id',
    name: 'showVocab',
    component: showVocab,
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
});

const app = new Vue({ router }).$mount('#app');
