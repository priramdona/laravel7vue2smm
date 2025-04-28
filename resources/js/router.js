import VueRouter from 'vue-router';
import RequestProductIndex from './views/RequestProduct/RequestProductIndex.vue';
import RequestProductCreate from './views/RequestProduct/RequestProductCreate.vue';

let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/products', component: require('./components/Products.vue').default },
    { path: '/employes', component: require('./components/Employes.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/request-products', name: 'request-products.index', component: RequestProductIndex },
    { path: '/request-product-create', name: 'request-products.create', component: RequestProductCreate },
  ]

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
