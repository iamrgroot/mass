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
    mdiDownload,
    mdiUpload,
    mdiCheck,
    mdiKey,
    mdiSearchWeb,
    mdiInformation,
    mdiCloudDownload,
    mdiPencil,
    mdiTimerSand,
    mdiClose,
    mdiCloudCheck,
    mdiAlertCircle
} from '@mdi/js';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        options: {
            customProperties: true,
        },
    },
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
            mdiDownload,
            mdiUpload,
            mdiCheck,
            mdiKey,
            mdiSearchWeb,
            mdiInformation,
            mdiCloudDownload,
            mdiPencil,
            mdiTimerSand,
            mdiClose,
            mdiCloudCheck,
            mdiAlertCircle
        }
    },
});
