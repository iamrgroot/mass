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

        <maintenance-form
            v-model="selected_item"
            @updated="updateRecord"
            @inserted="records.push(item)"
        />
    </v-container>
</template>

<script lang="ts">
import { computed, defineComponent, reactive, SetupContext, toRefs } from '@vue/composition-api';

import { capitalize } from '@/filters/filters';

import MaintenanceForm from '@/components/maintenance/Form.vue';
import { GeneralObject } from '@/types/Inputs';
import { useMaintenance } from '@/store/maintenance';
import { DataTableHeader } from 'vuetify';
import { deleteItem, getItems } from '@/api/maintenance';
import { updateObject } from '@/helpers/object';
import { updateArrayItem, removeArrayItem } from '@/helpers/array';

const useMaintenanceTable = (vm: SetupContext) => {
    const table_store = reactive({
        records: [] as GeneralObject[],
        selected_item: { id: 0 } as GeneralObject,
    });

    const { fields, table } = useMaintenance(vm);

    const headers = computed((): DataTableHeader[] => {
        const headers = Object.keys(fields.value)
            .filter(item =>
                (fields.value[item] as GeneralObject)['hide_in_table'] !== true
            )
            .map(item => {
                return { text: capitalize(item), value: item } as DataTableHeader;
            });
        headers.push({ text: '', value: 'actions', width: '100px', align: 'end', sortable: false } as DataTableHeader);

        return headers;
    });

    const newItem = (): void => {
        const fields_copy = {...fields.value};

        for (const key in fields_copy) {
            fields_copy[key] = null;
        }

        table_store.selected_item = updateObject(table_store.selected_item, {
            ...fields_copy,
            id: -1
        });
    };

    const update = (item: GeneralObject): void => {
        table_store.selected_item = updateObject(table_store.selected_item, item);        
    };

    const remove = async (item: GeneralObject): Promise<void> =>{
        if (! await vm.root.$confirm('Delete?')) {
            return;
        }

        await deleteItem(table.value, item);

        removeArrayItem(table_store.records, item);
    };

    const updateRecord = (item: GeneralObject): void => {
        updateArrayItem(table_store.records, item);
    };

    return {
        ...toRefs(table_store),
        table,
        headers,
        newItem,
        update,
        remove,
        updateRecord
    };
};

export default defineComponent({
    components: {
        MaintenanceForm,
    },
    setup(props, vm) {
        return {
            ...useMaintenanceTable(vm),
        };
    },
    async created() {
        this.records = await getItems(this.table);
    }
});
</script>