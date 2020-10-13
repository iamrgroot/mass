<template>
    <v-text-field
        :value="value"
        :label="label"
        :error-messages="errors"
        v-bind="bind_parameters"
        @input="value => $emit('input', value)"
    />
</template>

<script lang="ts">
import { Component, Vue, Prop, Watch } from 'vue-property-decorator';
import { Input, GeneralObject } from '@/types/Inputs';

@Component
export default class TextField extends Vue {
    @Prop({ required: true }) protected value!: Input;
    @Prop({ default: '' }) protected label!: string;
    @Prop({ default: () => { /** Empty function */} }) protected bind_parameters!: GeneralObject;
    @Prop({ default: () => [] }) protected errors!: string[] | null | undefined;

    @Prop({default: false}) protected success!: boolean;
    @Prop({default: false}) protected error!: boolean;

    @Watch('success')
    onSuccessChange(): void {
        if (! this.success) {
            return;
        }

        setTimeout(() => {
            this.$emit('update:success', false);
        }, 3000);
    }

    @Watch('error')
    onErrorChange(): void {
        if (! this.error) {
            return;
        }

        setTimeout(() => {
            this.$emit('update:error', false);
        }, 3000);
    }

    get append_icon(): string {
        if (this.success) {
            return '$mdiCheck';
        }

        if (this.error) {
            return '$mdiClose';
        }

        return '';
    }
}
</script>
