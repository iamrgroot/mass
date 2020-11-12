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
import { defineComponent } from '@vue/composition-api';

import { useSystem } from '@/store/system';

export default defineComponent({
    setup() {
        const { cpu_logs } = useSystem();

        return {
            cpu_logs
        };
    }
});
</script>