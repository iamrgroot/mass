import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';

import ListPage from '@/components/admin/item/ListPage.vue';
import ItemPage from '@/components/admin/item/ItemPage.vue';
import TorrentsPage from '@/components/admin/torrent/TorrentsPage.vue';
import AdminRequestsPage from '@/components/admin/request/AdminRequestsPage.vue';
import SystemPage from '@/components/admin/system/SystemPage.vue';

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
        // TODO maybe ?
        // component: () => import(/* webpackChunkName: "item" */ '@/components/item/ItemPage.vue'),
    },
    {
        path: '/movies',
        name: 'movies',
        component: ListPage,
    },
    {
        path: '/series/:id',
        name: 'serie',
        component: ItemPage,
    },
    {
        path: '/series',
        name: 'series',
        component: ListPage,
    },
    {
        path: '/torrents',
        name: 'torrents',
        component: TorrentsPage,
    },
    {
        path: '/requests',
        name: 'requests',
        component: AdminRequestsPage,
    },
    {
        path: '/system',
        name: 'system',
        component: SystemPage,
    },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
