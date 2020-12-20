import Vue from 'vue';

import '@/plugins/composition-api';
import router from '@/router/user';
import vuetify from '@/plugins/vuetify';
import { VNode } from 'vue/types/umd';

import User from '@/views/User.vue';

import { useUser } from '@/store/user';

const { fetchCrsfToken, fetchUser } = useUser();

Vue.config.productionTip = false;

new Vue({
    router,
    vuetify,
    async created(): Promise<void> {
        await fetchCrsfToken();
        fetchUser;
    },
    render: (h): VNode => h(User),
}).$mount('#app');
