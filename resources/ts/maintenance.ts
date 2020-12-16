import Vue from 'vue';

import '@/plugins/composition-api';
import router from '@/router/maintenance';
import vuetify from '@/plugins/vuetify';
import { VNode } from 'vue/types/umd';

import Maintenance from '@/views/Maintenance.vue';

import { useUser, } from './store/user';

const { fetchCrsfToken, fetchUser } = useUser();

Vue.config.productionTip = false;

new Vue({
    router,
    vuetify,
    created(): void {
        fetchCrsfToken();
        fetchUser();
    },
    render: (h): VNode => h(Maintenance)
}).$mount('#app');
