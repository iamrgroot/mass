import Vue from 'vue';

import '@/plugins/composition-api';
import vuetify from '@/plugins/vuetify';
import router from '@/router/admin';
import { VNode } from 'vue/types/umd';
import { useProfiles } from './store/profiles';

import Admin from '@/views/Admin.vue';

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
