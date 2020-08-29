import axios from '@/plugins/axios';
import { GeneralObject } from '@/types/Inputs';

function getRoute(table: string): string {
    return `/async/maintenance/${table}`;
}

export async function getItems(table: string): Promise<GeneralObject[]> {
    return (await axios.get(getRoute(table))).data;
}

export async function saveItem(table: string, item: GeneralObject): Promise<GeneralObject> {
    return (await axios.patch(getRoute(table), item)).data;
}

export async function deleteItem(table: string, item: GeneralObject): Promise<GeneralObject> {
    return (await axios.delete(`${getRoute(table)}/${item.id}`)).data;
}
