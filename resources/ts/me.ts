import Vue from 'vue';

import Me from './views/Me.vue';

Vue.config.productionTip = false;

import vuetify from './plugins/vuetify';

new Vue({
  vuetify,
  render: h => h(Me)
}).$mount('#app');