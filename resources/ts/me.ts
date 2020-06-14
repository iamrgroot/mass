import Vue from 'vue'
import vuetify from './plugins/vuetify'
import '@mdi/font/css/materialdesignicons.min.css'
import Me from './views/Me.vue'

Vue.config.productionTip = false

new Vue({
  vuetify,
  render: h => h(Me)
}).$mount('#app')