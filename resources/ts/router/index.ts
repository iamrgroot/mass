import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'

import ListPage from '@/components/item/ListPage.vue';
import ItemPage from '@/components/item/ItemPage.vue';
import TorrentsPage from '@/components/torrent/TorrentsPage.vue';

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
  {
    path: '/',
    name: 'home',
  },
  {
      path: '/movies/:id',
      name: 'movie',
      component: ItemPage,
      // TODO component: () => import('./components/Serie/Page.vue'),
  },
  {
      path: '/movies',
      name: 'movies',
      component: ListPage,
      // TODO component: () => import(/* webpackChunkName: "list-page" */ '@/components/item/ListPage.vue'),
  },
  {
      path: '/series/:id',
      name: 'serie',
      component: ItemPage,
      // TODO component: () => import('./components/Serie/Page.vue'),
  },
  {
      path: '/series',
      name: 'series',
      component: ListPage,
      // TODO component: () => import(/* webpackChunkName: "list-page" */ '@/components/item/ListPage.vue'),
  },
  {
      path: '/torrents',
      name: 'torrents',
      component: TorrentsPage,
      // TODO component: () => import('./components/Serie/Page.vue'),
  },
  // {
  //   path: '/about',
  //   name: 'About',
  //   // Magic comment to make webpack chuck from the component.
  //   component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  // }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

export default router
