import axios from '@/plugins/axios';
import { Request } from '@/types/Requests';
import { SearchResult } from '@/types/Item';
import { RequestStatus } from '@/enums/RequestStatus';

function getRoute(): string {
    return '/async/requests';
}

export async function getRequests(): Promise<Request[]> {
    return (await axios.get(getRoute())).data;
}

export async function putRequest(item: SearchResult): Promise<Request> {
    return (await axios.put(getRoute(), { item })).data;
}

export async function deleteRequest(request_id: number): Promise<boolean> {
    return (await axios.delete(`${getRoute()}/${request_id}`)).data;
}

export async function postRequestStatus(request_id: number, status_id: RequestStatus): Promise<Request> {
    return (await axios.post(`${getRoute()}/${request_id}/status/${status_id}`)).data;
}