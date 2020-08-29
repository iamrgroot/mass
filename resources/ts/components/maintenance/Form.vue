<template>
    <v-dialog
        :value="value && value.id !== 0"
        width="800px"
        @input="dialog => $emit('input', dialog ? value.id : 0)"
    >
        <v-card>
            <v-card-title>
                {{ table | capitalize }}
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
import { getItems, saveItem } from '@/api/maintenance';

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
    @Prop({ required: true }) private value!: GeneralObject;

    private errors = {};

    get table(): string {
        return this.$route.name as string;
    }
    get fields(): GeneralObject {
        return window.injected[this.table] as GeneralObject;
    }

    async save(): Promise<void> {
        try {
            this.$emit('saved', await saveItem(this.table, this.value));
        } catch (error) {
            this.errors = error.response.data.errors || [];
        }
    }
}
</script>