import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';

import MainPage from '@/components/user/MainPage.vue';

Vue.use(VueRouter);

const routes: RouteConfig[] = [
    {
        path: '/',
        name: 'home',
        component: MainPage,
        // component: () => import(/* webpackChunkName: "item" */ '@/components/item/ItemPage.vue'),
    },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
