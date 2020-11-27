<template>
    <v-card
        :loading="loading"
    >
        <v-card-title>
            <span>System</span>
            <v-spacer />
            <laravel-logs-button />
            <v-icon
                @click="settings_dialog = true"
            >
                $mdiCog
            </v-icon>
        </v-card-title>
        <v-divider class="mx-3" />
        <v-card-text>
            <v-row>
                <v-col cols="6">
                    <cpu-log-card />
                </v-col>
                <v-col cols="6">
                    <disk-log-card />
                </v-col>
                <v-col cols="6">
                    <memory-log-card />
                </v-col>
            </v-row>
        </v-card-text>

        <settings-bottom-sheet />
    </v-card>
</template>

<script lang="ts">
import { defineComponent, ref } from '@vue/composition-api';

import SettingsBottomSheet from '@/components/admin/system/SettingsBottomSheet.vue';
import CpuLogCard from '@/components/admin/system/logs/CpuLogCard.vue';
import DiskLogCard from '@/components/admin/system/logs/DiskLogCard.vue';
import MemoryLogCard from '@/components/admin/system/logs/MemoryLogCard.vue';
import LaravelLogsButton from '@/components/admin/system/logs/LaravelLogsButton.vue';

import { useSystem } from '@/store/system';

export default defineComponent({
    components: {
        SettingsBottomSheet,
        CpuLogCard,
        DiskLogCard,
        MemoryLogCard,
        LaravelLogsButton,
    },
    setup() {
        const { settings, settings_dialog, fetchLogs } = useSystem();

        const loading = ref(false);

        return {
            loading,
            settings,
            settings_dialog,
            fetchLogs,
        };
    },
    created() {
        this.fetchLogs();
    },
});
</script>