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
import dictionary from './components/vocabularies/dictionary';
import indexGrammar from './components/grammar/index';
import grammarArticle from './components/grammar/grammar-article';
import grammarList from './components/grammar/grammar-list';
import indexSetting from './components/setting/index';
import account from './components/setting/account';
import photos from './components/setting/photos';
import profile from './components/setting/profile';
import reminder from './components/setting/reminder';
import notifications from './components/setting/notifications';
import plan from './components/setting/plan';

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
    path: '/vocabularies/dictionary',
    name: 'dictionary',
    component: dictionary
  },
  {
    path: '/vocabularies/:id/new',
    name: 'newChildVocab',
    component: newVocab
  },
  {
    path: '/vocabularies/:id/edit',
    name: 'editVocab',
    component: editVocab
  },
  {
    path: '/vocabularies/:id',
    name: 'showVocab',
    component: showVocab
  },
  {
    path: '/grammars',
    name: 'indexGrammar',
    component: indexGrammar
  },
  {
    path: '/grammars/edit/:id',
    name: 'updateGrammar',
    component: indexGrammar
  },
  {
    path: '/grammars-article',
    name: 'grammarArticle',
    component: grammarArticle
  },
  {
    path: '/grammars-list',
    name: 'grammarList',
    component: grammarList
  },
  {
    path: '/setting',
    name: 'indexSetting',
    component: indexSetting,
    children: [
      {
        path: '/setting/account',
        name: 'account',
        component: account
      },
      {
        path: '/setting/photos',
        name: 'photos',
        component: photos
      },
      {
        path: '/setting/profile',
        name: 'profile',
        component: profile
      },
      {
        path: '/setting/notifications',
        name: 'notifications',
        component: notifications
      },
      {
        path: '/setting/reminder',
        name: 'reminder',
        component: reminder
      },
      {
        path: '/setting/plan',
        name: 'plan',
        component: plan
      }

    ]
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
});

const app = new Vue({ router }).$mount('#app');
