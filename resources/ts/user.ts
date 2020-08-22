import Vue from 'vue';

import Home from '@/views/Home.vue';

import router from '@/router/user';
import store from '@/store';
import vuetify from '@/plugins/vuetify';
import { VNode } from 'vue/types/umd';

Vue.config.productionTip = false;

new Vue({
    router,
    store,
    vuetify,
    render: (h): VNode => h(Home)
}).$mount('#app');
