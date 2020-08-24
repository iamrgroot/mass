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
                        :options="config.options"
                    />
                </v-row>
            </v-card-text>
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

    get table(): string {
        return this.$route.name as string;
    }
    get fields(): GeneralObject {
        return window.injected[this.table] as GeneralObject;
    }
}
</script>