import Vue from 'vue';

import '@/plugins/composition-api';
import vuetify from '@/plugins/vuetify';
import router from '@/router/admin';
import { VNode } from 'vue/types/umd';

import Admin from '@/views/Admin.vue';

import { useProfiles } from './store/profiles';
import { useItems } from './store/items';

Vue.config.productionTip = false;

const { initializeProfiles } = useProfiles();
const { fetchMovies, fetchSeries } = useItems();

new Vue({
    router,
    vuetify,
    created(): void {
        initializeProfiles();
        fetchMovies();
        fetchSeries();
    },
    render: (h): VNode => h(Admin)
}).$mount('#app');
