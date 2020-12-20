import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';

import Maintenance from '@/components/maintenance/Maintenance.vue';

Vue.use(VueRouter);

const routes: RouteConfig[] = [].map(key =>{ // TODO Object.keys(window.injected).map(key =>{
    return {
        path: `/maintenance/${key}`,
        name: `${key}`,
        component: Maintenance,
        // component: () => import(/* webpackChunkName: "item" */ '@/components/item/ItemPage.vue'),
    };
});

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
