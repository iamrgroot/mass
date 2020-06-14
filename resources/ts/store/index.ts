import Vue from 'vue'
import Vuex from 'vuex'

import Profiles from '@/store/modules/profiles';
import Items from '@/store/modules/items';

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        // User: null,
    },
    modules: {
        Profiles,
        Items,
    }
});

export default store;
