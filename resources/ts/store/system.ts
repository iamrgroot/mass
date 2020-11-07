import { reactive, toRefs } from '@vue/composition-api';

import { getCpuLogs, getDiskLogs, getMemoryLogs } from '@/api/system';

import { Setting, CpuLog, DiskLog, MemoryLog } from '@/types/System';

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
export const useSystem = () => {
    const system_store = reactive({
        settings_dialog: false,
        settings: [] as Setting[],
        cpu_logs: [] as CpuLog[],
        disk_logs: [] as DiskLog[],
        memory_logs: [] as MemoryLog[],
    });

    const fetchCpuLog = (): Promise<CpuLog[]> => {
        return new Promise((resolve, reject) => {
            getCpuLogs().then(data => {
                system_store.cpu_logs = data;
                resolve(data);
            }).catch(reject);
        });
    };
    const fetchDiskLog = (): Promise<DiskLog[]> => {
        return new Promise((resolve, reject) => {
            getDiskLogs().then(data => {
                system_store.disk_logs = data;
                resolve(data);
            }).catch(reject);
        });
    };

    const fetchMemoryLog = (): Promise<MemoryLog[]> => {
        return new Promise((resolve, reject) => {
            getMemoryLogs().then(data => {
                system_store.memory_logs = data;
                resolve(data);
            }).catch(reject);
        });
    };

    const fetchLogs = (): void => {
        Promise.all([
            fetchCpuLog(),
            fetchDiskLog(),
            fetchMemoryLog(),
        ]);
    };

    return {
        ...toRefs(system_store),
        fetchCpuLog,
        fetchDiskLog,
        fetchMemoryLog,
        fetchLogs,
    };
};