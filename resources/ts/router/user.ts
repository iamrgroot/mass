import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';

import ItemPage from '@/components/item/ItemPage.vue';

Vue.use(VueRouter);

const routes: RouteConfig[] = [
    {
        path: '/',
        name: 'home',
        redirect: '/movies'
    },
    {
        path: '/movies/:id',
        name: 'movie',
        component: ItemPage,
        // component: () => import(/* webpackChunkName: "item" */ '@/components/item/ItemPage.vue'),
    },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
