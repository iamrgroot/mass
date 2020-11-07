import Vue from 'vue';

import Admin from '@/views/Admin.vue';

import router from '@/router/admin';
import vuetify from '@/plugins/vuetify';
import { VNode } from 'vue/types/umd';
import { useProfiles } from './store/profiles';

Vue.config.productionTip = false;

const { initializeProfiles } = useProfiles();

new Vue({
    router,
    vuetify,
    created(): void {
        initializeProfiles();
    },
    render: (h): VNode => h(Admin)
}).$mount('#app');
