import Vue from 'vue';

import Login from '@/views/Login.vue';

Vue.config.productionTip = false;

import vuetify from './plugins/vuetify';
import { VNode } from 'vue/types/umd';

new Vue({
    vuetify,
    render: (h): VNode => h(Login)
}).$mount('#app');