<template>
    <v-card outlined>
        <v-simple-table height="300">
            <template v-slot:default>
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
                        <td>{{ log.used_space | byte }}</td>
                        <td>{{ log.total_space | byte }}</td>
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
import { MemoryLog } from '@/types/System';
import { byte } from '@/filters/filters';

@Component({
    filters: {
        byte,
    }
})
export default class MemoryLogCard extends Vue {
    get memory_logs(): MemoryLog[] {
        return system_store.memory_logs;
    }
}
</script>