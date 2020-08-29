<template>
    <v-dialog
        :value="value && value.id !== 0"
        width="800px"
        @input="dialog => $emit('input', dialog ? value.id : 0)"
    >
        <v-card>
            <v-card-title>
                {{ title | capitalize }}
            </v-card-title>
            <v-card-text>
                <v-row
                    v-for="(config, field) in fields"
                    :key="field"
                >
                    <component
                        :is="config.component"
                        v-model="value[field]"
                        :label="field | capitalize"
                        :options="config.relation"
                        :errors="errors[field]"
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
import { Component, Vue, Prop } from 'vue-property-decorator';
import { capitalize } from '@/filters/filters';
import TextField from '@/components/input/TextField.vue';
import Password from '@/components/input/Password.vue';
import SelectMultiple from '@/components/input/SelectMultiple.vue';
import { GeneralObject } from '../../types/Inputs';
import { saveItem } from '@/api/maintenance';

@Component({
    components: {
        TextField,
        Password,
        SelectMultiple
    },
    filters: {
        capitalize
    }
})
export default class Form extends Vue {
    @Prop({ required: true }) private value!: GeneralObject | null;

    private errors = {};

    get table(): string {
        return this.$route.name as string;
    }
    get fields(): GeneralObject {
        return window.injected[this.table] as GeneralObject;
    }
    get title(): string {
        let string = 'Edit';

        if (this.value !== null && this.value.id !== null && this.value.id < 0) {
            string = 'New';
        }

        return `${this.table} - ${string}`;
    }

    async save(): Promise<void> {
        if (this.value === null || this.value.id === null) {
            return;
        }

        try {
            const event = this.value.id < 0 ? 'inserted' : 'updated';

            this.$emit(event, await saveItem(this.table, this.value));
            this.$emit('input', { id: 0 });
        } catch (error) {
            this.errors = error.response.data.errors || [];
        }
    }
}
</script>