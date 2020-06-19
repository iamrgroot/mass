import Vue from 'vue'
import VueRouter, { RouteConfig } from 'vue-router'

import ListPage from '@/components/item/ListPage.vue';

Vue.use(VueRouter)

const routes: Array<RouteConfig> = [
  {
    path: '/',
    name: 'home',
  },
  {
      path: '/movies',
      name: 'movies',
      component: ListPage,
      // TODO component: () => import(/* webpackChunkName: "list-page" */ '@/components/item/ListPage.vue'),
  },
  // {
  //     path: '/series',
  //     name: 'series',
  //     component: ListPage,
  //     // TODO component: () => import(/* webpackChunkName: "list-page" */ '@/components/item/ListPage.vue'),
  // },
  // {
  //     path: '/movie/:id',
  //     name: 'movie',
  //     // component: ItemPage,
  //     // TODO component: () => import('./components/Serie/Page.vue'),
  // },
  // {
  //     path: '/serie/:id',
  //     name: 'serie',
  //     // component: ItemPage,
  //     // TODO component: () => import('./components/Serie/Page.vue'),
  // },
  // {
  //     path: '/torrents',
  //     name: 'torrents',
  //     // component: TorrentsPage,
  //     // TODO component: () => import('./components/Serie/Page.vue'),
  // },
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
