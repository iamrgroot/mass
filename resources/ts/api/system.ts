import axios from '@/plugins/axios';
import { SystemData } from '@/types/System';

export async function getSystemData(): Promise<SystemData> {
    return (await axios.get('/async/system')).data;
}