import axios from '@/plugins/axios';
import { GeneralObject } from '@/types/Inputs';

export async function getItems(table: string): Promise<GeneralObject[]> {
    return (await axios.get(`/async/maintenance/${table}`)).data;
}
