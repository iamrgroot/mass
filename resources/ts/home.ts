import Vue from 'vue';

import Home from '@/views/Home.vue';

import router from '@/router';
import store from '@/store';
import { i18n } from '@/plugins/i18n';
import vuetify from '@/plugins/vuetify';

Vue.config.productionTip = false;

new Vue({
    i18n,
    router,
    store,
    vuetify,
    render: h => h(Home)
}).$mount('#app');
