import VueRouter from 'vue-router';
import RequestProductIndex from './views/RequestProduct/RequestProductIndex.vue';
import RequestProductCreate from './views/RequestProduct/RequestProductCreate.vue';

const routes = [
    { path: '/', name: 'request-products.index', component: RequestProductIndex },
    { path: '/create', name: 'request-products.create', component: RequestProductCreate },
];

const routes = new VueRouter({
    mode: 'history',
    routes
});

export default routes;