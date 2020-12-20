import Vue from 'vue';

import '@/plugins/composition-api';
import vuetify from '@/plugins/vuetify';
import router from '@/router/admin';
import { VNode } from 'vue/types/umd';

import Admin from '@/views/Admin.vue';

import { useProfiles } from './store/profiles';
import { useItems } from './store/items';
import { useUser } from './store/user';

Vue.config.productionTip = false;

const { fetchCrsfToken, fetchUser } = useUser();
const { initializeProfiles } = useProfiles();
const { fetchMovies, fetchSeries } = useItems();

new Vue({
    router,
    vuetify,
    async created(): Promise<void> {
        await fetchCrsfToken();
        fetchUser();
        initializeProfiles();
        fetchMovies();
        fetchSeries();
    },
    render: (h): VNode => h(Admin)
}).$mount('#app');
