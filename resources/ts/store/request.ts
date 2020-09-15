import Vue from 'vue';
import { Request } from '@/types/Requests';

export const request_store = Vue.observable({
    requests: [] as Request[],
});