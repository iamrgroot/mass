import axios from '@/plugins/axios';
import { Request } from '@/types/Requests';

function getRoute(): string {
    return '/async/requests';
}

export async function getRequests(): Promise<Request[]> {
    return (await axios.get(getRoute())).data;
}

export async function putRequest(): Promise<Request> {
    return (await axios.put(getRoute())).data;
}

export async function deleteRequest(request_id: number): Promise<Request> {
    return (await axios.delete(`${getRoute()}/${request_id.toString()}`)).data;
}
