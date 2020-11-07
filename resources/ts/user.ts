import Vue from 'vue';

import User from '@/views/User.vue';

import router from '@/router/user';
import vuetify from '@/plugins/vuetify';
import { VNode } from 'vue/types/umd';

Vue.config.productionTip = false;

new Vue({
    router,
    vuetify,
    render: (h): VNode => h(User)
}).$mount('#app');
