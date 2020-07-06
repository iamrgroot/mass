import Vue from 'vue';
import VueI18n from 'vue-i18n';

import dateTimeFormats from './i18n/data-time-format';
import numberFormats from './i18n/number.format';

// register i18n module
Vue.use(VueI18n);

const i18n = new VueI18n({
   locale: 'en', //if you need get the browser language use following "window.navigator.language"
   fallbackLocale: 'en',
   dateTimeFormats,
   numberFormats,
});

const translate = (key: string): string => {
    if (!key) {
        return '';
    }

    return i18n.t(key) as string;
};

export { i18n, translate };