import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';

import ListPage from '@/components/admin/item/ListPage.vue';
import TorrentsPage from '@/components/admin/torrent/TorrentsPage.vue';
import AdminRequestsPage from '@/components/admin/request/AdminRequestsPage.vue';
import SystemPage from '@/components/admin/system/SystemPage.vue';

import { useItems } from '@/store/items';
import { ItemType } from '@/enums/ItemType';

Vue.use(VueRouter);

const { route_type } = useItems();

const routes: RouteConfig[] = [
    {
        path: '/',
        name: 'home',
        redirect: '/movies',
    },
    {
        path: '/movies',
        name: 'movies',
        component: ListPage,
        beforeEnter: (to, from, next): void => {
            route_type.value = ItemType.Movie;
            next();
        },
    },
    {
        path: '/series',
        name: 'series',
        component: ListPage,
        beforeEnter: (to, from, next): void => {
            route_type.value = ItemType.Serie;
            next();
        },
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
