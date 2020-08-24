<template>
    <v-text-field
        :value="value"
        :label="label"
        v-bind="bind_parameters"
        @input="value => $emit('input', value)"
    />
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { Input } from '@/types/Inputs';

@Component
export default class TextField extends Vue {
    @Prop({ required: true }) protected value!: Input;
    @Prop({ default: '' }) protected label!: string;
    @Prop({ default: () => { /** Empty function */} }) protected bind_parameters!: Record<string, unknown>;
}
</script>
