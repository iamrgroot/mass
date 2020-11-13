<template>
    <v-card outlined>
        <v-simple-table height="300">
            <template #default>
                <thead>
                    <tr>
                        <th class="text-left">
                            RAM Used
                        </th>
                        <th class="text-left">
                            Total
                        </th>
                        <th class="text-left">
                            At
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="log in memory_logs"
                        :key="log.id"
                    >
                        <td>{{ byte(log.used_space) }}</td>
                        <td>{{ byte(log.total_space) }}</td>
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

import { byte } from '@/filters/filters';

export default defineComponent({
    setup() {
        const { memory_logs } = useSystem();

        return {
            memory_logs,
            byte,
        };
    }
});
</script>