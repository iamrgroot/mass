<template>
    <v-card outlined>
        <v-simple-table height="300">
            <template v-slot:default>
                <thead>
                    <tr>
                        <th class="text-left">
                            Path
                        </th>
                        <th class="text-left">
                            Used
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
                        v-for="log in disk_logs"
                        :key="log.id"
                    >
                        <td>{{ log.path }}</td>
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
        const { disk_logs } = useSystem();

        return {
            disk_logs,
            byte
        };
    }
});
</script>