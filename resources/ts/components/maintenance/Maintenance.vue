<template>
    <v-container fluid>
        <v-data-table
            :headers="headers"
            :items="records"
            class="elevation-1"
        >
            <template #[`item.actions`]="{ item }">
                <v-icon
                    color="primary"
                    @click="update(item)"
                >
                    $mdiPencil
                </v-icon>
                <v-icon
                    color="error"
                    class="ml-3"
                    @click="remove(item)"
                >
                    $mdiDelete
                </v-icon>
            </template>
        </v-data-table>

        <Form v-model="selected_item" />
    </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { capitalize } from '@/filters/filters';
import { getItems } from '@/api/maintenance';
import Form from '@/components/maintenance/Form.vue';
import { DataTableHeader } from 'vuetify';
import { GeneralObject } from '@/types/Inputs';

@Component({
    components: {
        Form,
    },
    filters: {
        capitalize
    }
})
export default class Maintenance extends Vue {
    private records: GeneralObject[] = [];
    private selected_item: GeneralObject = { id: 0 };

    get table(): string {
        return this.$route.name as string;
    }
    get fields(): GeneralObject {
        return window.injected[this.table] as GeneralObject;
    }
    get headers(): DataTableHeader[] {
        const headers = Object.keys(this.fields)
            .filter(item =>
                (this.fields[item] as GeneralObject)['hide_in_table'] !== true
            )
            .map(item => {
                return { text: capitalize(item), value: item } as DataTableHeader;
            });
        headers.push({ text: '', value: 'actions', width: '100px', align: 'end' } as DataTableHeader);
        return headers;
    }

    async created(): Promise<void> {
        this.records = await getItems(this.table);
    }

    update(item: GeneralObject): void {
        this.selected_item = Object.assign({}, this.selected_item, item);
    }
    remove(item: unknown): void {
        throw new Error('TODO implement this pls');
    }
}
</script>