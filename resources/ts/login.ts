import Vue from 'vue'
import vuetify from './plugins/vuetify'
import '@mdi/font/css/materialdesignicons.min.css'
import Login from './views/Login.vue'

Vue.config.productionTip = false

new Vue({
  vuetify,
  render: h => h(Login)
}).$mount('#app')