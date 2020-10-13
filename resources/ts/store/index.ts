import Vue from 'vue';
import Vuex from 'vuex';

import Items from '@/store/modules/items';
import Notifications from '@/store/modules/notifications';
import Torrents from '@/store/modules/torrents';
import Indexers from '@/store/modules/indexers';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        // User: null,
    },
    modules: {
        Items,
        Notifications,
        Torrents,
        Indexers,
    }
});

export default store;
