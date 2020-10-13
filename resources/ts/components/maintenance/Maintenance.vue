<template>
    <v-container fluid>
        <v-data-table
            :headers="headers"
            :items="records"
            class="elevation-1"
        >
            <template #[`header.actions`]>
                <v-btn
                    outlined
                    @click="newItem"
                >
                    New
                </v-btn>
            </template>
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

        <Form
            v-model="selected_item"
            @updated="updateRecord"
            @inserted="insertRecord"
        />
    </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { capitalize } from '@/filters/filters';
import { getItems, deleteItem } from '@/api/maintenance';
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
        headers.push({ text: '', value: 'actions', width: '100px', align: 'end', sortable: false } as DataTableHeader);
        return headers;
    }

    async created(): Promise<void> {
        this.records = await getItems(this.table);
    }

    newItem(): void {
        const fields = {...this.fields};

        for (const key in fields) {
            fields[key] = null;
        }

        this.selected_item = Object.assign(
            {},
            this.selected_item,
            {
                ...fields,
                id: -1
            }
        );
    }
    update(item: GeneralObject): void {
        this.selected_item = Object.assign({}, this.selected_item, item);
    }
    async remove(item: GeneralObject): Promise<void> {
        if (! await this.$root.$confirm('Delete?')) {
            return;
        }

        await deleteItem(this.table, item);

        this.records.splice(
            this.records.findIndex(old_item => {
                return item.id === old_item.id;
            }),
            1
        );
    }
    updateRecord(item: GeneralObject): void {
        this.records.splice(
            this.records.findIndex(old_item => {
                return item.id === old_item.id;
            }),
            1,
            item
        );
    }
    insertRecord(item: GeneralObject): void {
        this.records.push(item);
    }
}
</script>