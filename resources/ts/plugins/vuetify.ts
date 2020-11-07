import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import VueCompositionAPI from '@vue/composition-api';

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
    mdiAlertCircle,
    mdiMovie,
    mdiTelevision,
    mdiCog,
    mdiMessageAlert,
    mdiQualityHigh
} from '@mdi/js';

Vue.use(Vuetify);
Vue.use(VueCompositionAPI);

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
            mdiAlertCircle,
            mdiMovie,
            mdiTelevision,
            mdiCog,
            mdiMessageAlert,
            mdiQualityHigh
        }
    },
});
