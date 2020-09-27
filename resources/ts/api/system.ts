import axios from '@/plugins/axios';
import { Setting, SettingValue } from '@/types/System';

export async function getSettings(): Promise<Setting[]> {
    return (await axios.get('/async/system/settings')).data;
}

export async function updateSetting(name: string, value: SettingValue): Promise<Setting> {
    return (await axios.patch('/async/system/setting', {name, value})).data;
}