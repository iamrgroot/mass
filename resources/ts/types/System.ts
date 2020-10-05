export type SettingValue = string|number|boolean;

export type Setting = {
    name: string;
    component: string;
    previous_value: SettingValue;
    value: SettingValue;
    updated_at: string;
    updating: boolean;
    error: boolean;
    success: boolean;
}

export type CpuLog = {
    id: number;
    cpu_usage: number;
    created_at: string;
}

export type DiskLog = {
    id: number;
    path: string;
    used_space: number;
    total_space: number;
}

export type MemoryLog = {
    id: number;
    used_space: number;
    total_space: number;
}