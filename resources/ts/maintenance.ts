import Vue from 'vue';

import Maintenance from '@/views/Maintenance.vue';

import router from '@/router/maintenance';
import store from '@/store';
import vuetify from '@/plugins/vuetify';
import { VNode } from 'vue/types/umd';

Vue.config.productionTip = false;

new Vue({
    router,
    store,
    vuetify,
    render: (h): VNode => h(Maintenance)
}).$mount('#app');
