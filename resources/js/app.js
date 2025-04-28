/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import {
  Button,
  HasError,
  AlertError,
  AlertErrors,
  AlertSuccess
} from 'vform/src/components/bootstrap4'
// 'vform/src/components/bootstrap4'
// 'vform/src/components/tailwind'

import Swal from 'sweetalert2'; // Import SweetAlert2


Vue.component(Button.name, Button)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)

import VueRouter from 'vue-router';
import router from './router';

require('admin-lte/plugins/datepicker/bootstrap-datepicker.js');
require('admin-lte/plugins/select2/select2.full.min.js');
Vue.use(VueRouter);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('request-form', require('./components/RequestForm.vue').default);
Vue.component('request-list', require('./components/RequestList.vue').default);

const app = new Vue({
    el: '#app',
    router
});
