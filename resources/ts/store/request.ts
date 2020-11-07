import { reactive, toRefs } from '@vue/composition-api';

import { Request } from '@/types/Requests';

export const useRequests = () => {
    const request_store = reactive({
        requests: [] as Request[],
    });

    return {
        ...toRefs(request_store),
    };
};