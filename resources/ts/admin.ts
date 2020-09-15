import Vue from 'vue';

import Admin from '@/views/Admin.vue';

import router from '@/router/admin';
import store from '@/store';
import vuetify from '@/plugins/vuetify';
import { VNode } from 'vue/types/umd';

Vue.config.productionTip = false;

new Vue({
    router,
    store,
    vuetify,
    render: (h): VNode => h(Admin)
}).$mount('#app');
