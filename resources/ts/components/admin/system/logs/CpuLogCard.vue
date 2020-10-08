<template>
    <v-card outlined>
        <v-simple-table height="300">
            <template v-slot:default>
                <thead>
                    <tr>
                        <th class="text-left">
                            CPU Usage
                        </th>
                        <th class="text-left">
                            At
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="log in cpu_logs"
                        :key="log.id"
                    >
                        <td>{{ log.cpu_usage }}</td>
                        <td>{{ log.created_at }}</td>
                    </tr>
                </tbody>
            </template>
        </v-simple-table>
    </v-card>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { system_store } from '@/store/system';
import { CpuLog } from '@/types/System';

@Component
export default class CpuLogCard extends Vue {
    get cpu_logs(): CpuLog[] {
        return system_store.cpu_logs;
    }
}
</script>