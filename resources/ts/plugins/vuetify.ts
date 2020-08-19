import Vue from 'vue';
import Vuetify from 'vuetify/lib';

import {
    mdiDatabaseSearch,
    mdiMagnify,
    mdiRefresh,
    mdiDelete,
    mdiSortAscending,
    mdiSortDescending,
    mdiCloudAlert,
    mdiHome,
    mdiPause,
    mdiPlay,
    mdiAlert,
    mdiAccount,
    mdiEmail,
    mdiLogout,
    mdiKey,
} from '@mdi/js';

Vue.use(Vuetify);

export default new Vuetify({
    icons: {
        iconfont: 'mdiSvg',
        values: {
            mdiDatabaseSearch,
            mdiMagnify,
            mdiRefresh,
            mdiDelete,
            mdiSortAscending,
            mdiSortDescending,
            mdiCloudAlert,
            mdiHome,
            mdiPause,
            mdiPlay,
            mdiAlert,
            mdiAccount,
            mdiEmail,
            mdiLogout,
            mdiKey,
        }
    },
});
