import Vue from 'vue';

export const locale_store = Vue.observable({
    locale: 'nl'
});

export const short_time_options: Intl.DateTimeFormatOptions = {
    hour: '2-digit',
    minute:'2-digit'
};