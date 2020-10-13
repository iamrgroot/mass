import Vue from 'vue';

import Admin from '@/views/Admin.vue';

import router from '@/router/admin';
import store from '@/store';
import vuetify from '@/plugins/vuetify';
import { VNode } from 'vue/types/umd';
import { initializeProfiles } from './store/profiles';

Vue.config.productionTip = false;

new Vue({
    router,
    store,
    vuetify,
    created(): void {
        initializeProfiles();
    },
    render: (h): VNode => h(Admin)
}).$mount('#app');
