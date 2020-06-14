import Vue from 'vue'
import Home from './views/Home.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';
import '@mdi/font/css/materialdesignicons.min.css'

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: h => h(Home)
}).$mount('#app')
