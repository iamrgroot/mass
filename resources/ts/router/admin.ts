import Vue from 'vue';
import VueRouter, { RouteConfig } from 'vue-router';

import ListPage from '@/components/admin/item/ListPage.vue';
import ItemPage from '@/components/admin/item/ItemPage.vue';
import TorrentsPage from '@/components/admin/torrent/TorrentsPage.vue';
import AdminRequestsPage from '@/components/admin/request/AdminRequestsPage.vue';
import SystemPage from '@/components/admin/system/SystemPage.vue';

import { useItems } from '@/store/items';
import { ItemType } from '@/enums/ItemType';
import { useToolbar } from '@/store/toolbar';

Vue.use(VueRouter);

const { route_type, item, movies, series } = useItems();
const { show_toolbar } = useToolbar();

const routes: RouteConfig[] = [
    {
        path: '/',
        name: 'home',
        redirect: '/movies',
    },
    {
        path: '/movies/:id',
        name: 'movie',
        component: ItemPage,
        beforeEnter: (to, from, next): void => {
            route_type.value = ItemType.Movie;
            show_toolbar.value = false;

            item.value = movies.value.find(item => item.id === Number(to.params.id)) ?? null;

            if (item.value === null) {
                next('/movies');
            }

            next();
        },
        // TODO maybe ?
        // component: () => import(/* webpackChunkName: "item" */ '@/components/item/ItemPage.vue'),
    },
    {
        path: '/movies',
        name: 'movies',
        component: ListPage,
        beforeEnter: (to, from, next): void => {
            route_type.value = ItemType.Movie;
            show_toolbar.value = true;
            next();
        },
    },
    {
        path: '/series/:id',
        name: 'serie',
        component: ItemPage,
        beforeEnter: (to, from, next): void => {
            route_type.value = ItemType.Serie;
            show_toolbar.value = false;

            item.value = series.value.find(item => item.id === Number(to.params.id)) ?? null;

            if (item.value === null) {
                next('/series');
            }

            next();
        },
    },
    {
        path: '/series',
        name: 'series',
        component: ListPage,
        beforeEnter: (to, from, next): void => {
            route_type.value = ItemType.Serie;
            show_toolbar.value = true;
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
    routes,
    // eslint-disable-next-line @typescript-eslint/explicit-function-return-type
    scrollBehavior(to, from, saved_position) {
        if (saved_position) {
            return saved_position;
        }
        return {x: 0, y: 0};
    }
});

export default router;
