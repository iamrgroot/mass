import Vue from 'vue';

import Login from './views/Login.vue';

Vue.config.productionTip = false;

import vuetify from './plugins/vuetify';

new Vue({
    vuetify,
    render: h => h(Login)
}).$mount('#app');