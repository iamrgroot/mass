import axios from '@/plugins/axios';
import { Setting, SettingValue, CpuLog, DiskLog, MemoryLog } from '@/types/System';

export async function getSettings(): Promise<Setting[]> {
    return (await axios.get('/async/system/settings')).data;
}

export async function updateSetting(name: string, value: SettingValue): Promise<Setting> {
    return (await axios.patch('/async/system/setting', {name, value})).data;
}

export async function getCpuLogs(): Promise<CpuLog[]> {
    return (await axios.get('/async/system/cpu-logs')).data;
}

export async function getDiskLogs(): Promise<DiskLog[]> {
    return (await axios.get('/async/system/disk-logs')).data;
}

export async function getMemoryLogs(): Promise<MemoryLog[]> {
    return (await axios.get('/async/system/memory-logs')).data;
}