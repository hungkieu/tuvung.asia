require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);
import VuePaginate from 'vue-paginate';
Vue.use(VuePaginate);

import VueToastr2 from 'vue-toastr-2';
import 'vue-toastr-2/dist/vue-toastr-2.min.css';

window.toastr = require('toastr');

Vue.use(VueToastr2);
window.notify = new Vue();
window.flash = function(message, status, title = '') {
  window.notify.$emit('flash', { message, status, title });
};

import flash from './components/shared/flash';
import index from './components/admin/index';
// import newStructure from './components/structure_sentences/new';
import indexUsers from './components/admin/users/index';
import profile from './components/admin/users/profile';
import indexVocabularies from './components/admin/vocabularies/index';
import indexGrammar from './components/admin/grammar/index';
import indexStructure from './components/admin/structure-grammar/index';
import newStructure from './components/admin/structure-grammar/new-structure';
import indexCategoryStructure from './components/admin/structure-grammar/index-category-structure';
import indexDashboard from './components/admin/dashboard/index';
const routes = [
  {
    path: '/admin',
    component: index
  },
  // {
  //   path: '/admin/structure_sentences/new',
  //   component: newStructure,
  //   name: 'new_structure_sentences'
  // },
  {
    path: '/admin/users',
    component: indexUsers,
    name: 'admin_users'
  },
  {
    path: '/admin/users/profile/:id',
    component: profile,
    name: 'admin_user_profile'
  },
  {
    path: '/admin/vocabularies',
    component: indexVocabularies,
    name: 'admin_vocabularies'
  },
  {
    path: '/admin/grammar',
    component: indexGrammar,
    name: 'indexGrammar'
  },
  {
    path: '/admin/structure-grammars',
    component: indexStructure,
    name: 'indexStructure'
  },
  {
    path: '/admin/structure-grammars/new',
    component: newStructure,
    name: 'newStructure'
  },
  {
    path: '/admin/category-structure-grammars',
    component: indexCategoryStructure,
    name: 'indexCategoryStructure'
  },
  {
    path: '/admin/dashboard',
    component: indexDashboard,
    name: 'indexDashboard'
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
});

const app = new Vue({
  router,
  components: {
    Flash: flash
  }
}).$mount('#admin');
