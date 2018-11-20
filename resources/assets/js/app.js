require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

import VueToastr2 from 'vue-toastr-2'
import 'vue-toastr-2/dist/vue-toastr-2.min.css'

window.toastr = require('toastr')

Vue.use(VueToastr2)


import flash from './components/shared/flash';
import index from './components/home/index';
import vocabularies from './components/vocabularies/index';
import newVocab from './components/vocabularies/new';
import UserProfile from './components/users/show';
import editVocab from './components/vocabularies/edit';
import showVocab from './components/vocabularies/show';
import dictionary from './components/vocabularies/dictionary';
import practice from './components/vocabularies/practice';
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
    name: 'indexVocab',
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
    path: '/vocabularies/practice',
    name: 'practiceVocab',
    component: practice
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
    component: indexSetting,
    children: [
      {
        path: '',
        component: account
      },
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
        path: '/setting/study-goal',
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

window.notify = new Vue();
window.flash = function(message, status, title = '') {
  window.notify.$emit('flash', {message, status, title});
}

const app = new Vue({
  router,
  components: {
    Flash: flash
  }
}).$mount('#app');
