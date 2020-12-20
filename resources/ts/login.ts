import Vue from 'vue';

import '@/plugins/composition-api';
import vuetify from './plugins/vuetify';
import { VNode } from 'vue/types/umd';

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