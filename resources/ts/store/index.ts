import Vue from 'vue'
import Vuex from 'vuex'

import Profiles from '@/store/modules/profiles';
import Items from '@/store/modules/items';
import Notifications from '@/store/modules/notifications';
import Torrents from '@/store/modules/torrents';

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        // User: null,
    },
    modules: {
        Profiles,
        Items,
        Notifications,
        Torrents,
    }
});

export default store;
