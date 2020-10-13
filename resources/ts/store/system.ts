import Vue from 'vue';
import { Setting, CpuLog, DiskLog, MemoryLog } from '@/types/System';
import { getCpuLogs, getDiskLogs, getMemoryLogs } from '@/api/system';

export const system_store = Vue.observable({
    settings_dialog: false,
    settings: [] as Setting[],
    cpu_logs: [] as CpuLog[],
    disk_logs: [] as DiskLog[],
    memory_logs: [] as MemoryLog[],
});

export async function fetchLogs(): Promise<void>{
    const fetchCpuLog = new Promise((resolve, reject) => {
        getCpuLogs().then(data => {
            system_store.cpu_logs = data;
            resolve(data);
        }).catch(reject);
    });
    const fetchDiskLog = new Promise((resolve, reject) => {
        getDiskLogs().then(data => {
            system_store.disk_logs = data;
            resolve(data);
        }).catch(reject);
    });
    const fetchMemoryLog = new Promise((resolve, reject) => {
        getMemoryLogs().then(data => {
            system_store.memory_logs = data;
            resolve(data);
        }).catch(reject);
    });

    Promise.all([
        fetchCpuLog,
        fetchDiskLog,
        fetchMemoryLog,
    ]);
}