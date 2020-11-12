import Vue from 'vue';

import '@/plugins/composition-api';
import vuetify from './plugins/vuetify';
import { VNode } from 'vue/types/umd';

import Login from '@/views/Login.vue';

new Vue({
    vuetify,
    render: (h): VNode => h(Login)
}).$mount('#app');