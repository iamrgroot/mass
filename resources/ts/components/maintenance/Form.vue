<template>
    <v-dialog
        :value="value && value.id !== 0"
        width="800px"
        @input="dialog => $emit('input', dialog ? value : {id: 0})"
    >
        <v-card>
            <v-card-title>
                {{ capitalize(title) }}
            </v-card-title>
            <v-card-text>
                <v-row
                    v-for="(config, field) in fields"
                    :key="field"
                >
                    <component
                        :is="config.component"
                        :value="value[field]"
                        :label="capitalize(field)"
                        :options="config.relation"
                        :errors="errors[field]"
                        @input="new_value => updateProp(field, new_value)"
                    />
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    color="success"
                    text
                    @click="save"
                >
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script lang="ts">
import { computed, defineComponent } from '@vue/composition-api';

import { capitalize } from '@/filters/filters';

import TextField from '@/components/input/TextField.vue';
import Password from '@/components/input/Password.vue';
import SelectMultiple from '@/components/input/SelectMultiple.vue';

import { saveItem } from '@/api/maintenance';
import { useMaintenance } from '@/store/maintenance';

export default defineComponent({
    components: {
        TextField,
        Password,
        SelectMultiple
    },
    props: {
        value: {
            type: Object,
            validator: (): boolean => true,
            required: true,
        },
    },
    setup(props, vm) {
        const { errors, fields, table } = useMaintenance(vm);

        const title = computed((): string => {
            let string = 'Edit';

            if (props.value && props.value.id !== null && props.value.id < 0) {
                string = 'New';
            }

            return `${table.value} - ${string}`;
        });

        const save = async (): Promise<void> => {
            if (! props.value || props.value.id === null) {
                return;
            }

            try {
                const event = props.value.id < 0 ? 'inserted' : 'updated';

                vm.emit(event, await saveItem(table.value, props.value));
                vm.emit('input', { id: 0 });
            } catch (error) {
                errors.value = error.response.data.errors || [];
            }
        };

        const updateProp = (field: string, new_value: unknown) => {
            const updated_value = {...props.value};

            updated_value[field] = new_value;

            vm.emit('input', updated_value);
        };

        return {
            errors,
            fields,
            save,
            updateProp,
            title,
            capitalize,
        };
    }
});
</script>