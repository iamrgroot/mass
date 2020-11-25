import Vue from 'vue';

import '@/plugins/composition-api';
import router from '@/router/maintenance';
import vuetify from '@/plugins/vuetify';
import { VNode } from 'vue/types/umd';

import Maintenance from '@/views/Maintenance.vue';

Vue.config.productionTip = false;

new Vue({
    router,
    vuetify,
    render: (h): VNode => h(Maintenance)
}).$mount('#app');
