import Vue from 'vue';
import { Setting } from '@/types/System';

export const system_store = Vue.observable({
    settings_dialog: false,
    settings: [] as Setting[],
});