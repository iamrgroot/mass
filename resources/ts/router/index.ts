import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';

import ListPage from '@/components/item/ListPage.vue';
import ItemPage from '@/components/item/ItemPage.vue';
import TorrentsPage from '@/components/torrent/TorrentsPage.vue';

Vue.use(VueRouter);

const routes: Array<RouteConfig> = [
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
    {
        path: '/movies',
        name: 'movies',
        component: ListPage,
        // component: () => import(/* webpackChunkName: "item-list" */ '@/components/item/ListPage.vue'),
    },
    {
        path: '/series/:id',
        name: 'serie',
        component: ItemPage,
        // component: () => import(/* webpackChunkName: "item" */ '@/components/item/ItemPage.vue'),
    },
    {
        path: '/series',
        name: 'series',
        component: ListPage,
        // component: () => import(/* webpackChunkName: "item-list" */ '@/components/item/ListPage.vue'),
    },
    {
        path: '/torrents',
        name: 'torrents',
        component: TorrentsPage,
        // component: () => import(/* webpackChunkName: "torrents" */ '@/components/torrent/TorrentsPage.vue'),
    },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
