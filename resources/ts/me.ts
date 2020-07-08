import Vue from 'vue';

import Me from './views/Me.vue';

Vue.config.productionTip = false;

import vuetify from './plugins/vuetify';
import { VNode } from 'vue/types/umd';

new Vue({
    vuetify,
    render: (h): VNode => h(Me)
}).$mount('#app');