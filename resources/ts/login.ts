import Vue from 'vue';
import { VNode } from 'vue/types/umd';

import '@/plugins/composition-api';
require('@/plugins/service-worker');

import vuetify from './plugins/vuetify';

import Login from '@/views/Login.vue';

import { useUser } from '@/store/user';

const { fetchCrsfToken } = useUser();

new Vue({
    vuetify,
    async created(): Promise<void> {
        await fetchCrsfToken();
    },
    render: (h): VNode => h(Login)
}).$mount('#app');