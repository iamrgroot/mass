<template>
    <v-dialog v-model="dialog">
        <template #activator="{ on, attrs }">
            <v-btn
                text
                v-bind="attrs"
                v-on="on"
            >
                Laravel <v-icon class="ml-3">
                    $mdiMessageAlert
                </v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-title class="headline grey lighten-2">
                <v-row align="center">
                    <span>Laravel Log</span>
                    <v-spacer />
                    <v-select
                        v-model="selected"
                        :items="logs"
                        :loading="loading_options"
                        label="Log file"
                        style="max-width: 300px;"
                    />
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="12">
                        <v-textarea
                            v-model="log"
                            :loading="loading"
                            auto-grow
                            readonly
                        />
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script lang="ts">
import { defineComponent, reactive, toRefs, watch } from '@vue/composition-api';

import { getLaravelLog, getLaravelLogs } from '@/api/system';

const useLogs = () => {
    const log_store = reactive({
        logs: [] as string[],
        dialog: false,
        loading_options: false,
        loading: false,
        selected: '',
        log: '',
    });

    watch(() => log_store.dialog, async () => {
        log_store.loading_options = true;
        log_store.logs = await getLaravelLogs();
        log_store.loading_options = false;
    });

    watch(() => log_store.selected, async () => {
        log_store.loading = true;
        log_store.log = await getLaravelLog(log_store.logs.indexOf(log_store.selected));
        log_store.loading = false;
    });

    return {
        ...toRefs(log_store),
    };
};

export default defineComponent({
    setup() {
        return {
            ...useLogs(),
        };
    }
});
</script>