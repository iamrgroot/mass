import { reactive, toRefs } from '@vue/composition-api';

import { Request } from '@/types/Requests';
import { deleteRequest, getRequests, postRequestStatus } from '@/api/request';
import { RequestStatus } from '@/enums/RequestStatus';
import { removeArrayItem, updateArrayItem } from '@/helpers/array';

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
export const useRequests = () => {
    const request_store = reactive({
        requests: [] as Request[],
        requests_loading: false,
        processing_request_id: -1,
    });

    const fetchRequests = (): Promise<Request[]> => {
        return new Promise((resolve, reject) => {
            request_store.requests_loading = true;

            getRequests()
                .then(requests => {
                    request_store.requests = requests;

                    resolve();
                })
                .catch(reject)
                .finally(() => {
                    request_store.requests_loading = false;
                });
        });
    };


    const removeRequest = (request: Request): Promise<void> => {
        return new Promise((resolve, reject) => {
            request_store.processing_request_id = request.id;

            deleteRequest(request.id)
                .then(() => {
                    removeArrayItem(request_store.requests, request);

                    resolve();
                })
                .catch(reject)
                .finally(() => {
                    request_store.processing_request_id = -1;
                });
        });
    };

    const updateRequest = async (request: Request, status: RequestStatus): Promise<Request> => {
        return new Promise((resolve, reject) => {
            request_store.processing_request_id = request.id;

            postRequestStatus(request.id, status)
                .then(updated_request => {
                    updateArrayItem(request_store.requests, updated_request);

                    resolve(updated_request);
                })
                .catch(reject)
                .finally(() => {
                    request_store.processing_request_id = -1;
                });
        });
    };

    return {
        ...toRefs(request_store),
        fetchRequests,
        removeRequest,
        updateRequest,
    };
};