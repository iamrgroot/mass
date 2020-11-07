import { reactive, toRefs } from '@vue/composition-api';

import { Request } from '@/types/Requests';

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
export const useRequests = () => {
    const request_store = reactive({
        requests: [] as Request[],
    });

    return {
        ...toRefs(request_store),
    };
};