import Vue from 'vue'
import vuetify from '@/plugins/vuetify'
import '@mdi/font/css/materialdesignicons.min.css'

import Home from '@/views/Home.vue'

import router from '@/router'
import store from '@/store'
import { i18n } from '@/plugins/i18n';

Vue.config.productionTip = false

new Vue({
  i18n,
  router,
  store,
  vuetify,
  render: h => h(Home)
}).$mount('#app')
