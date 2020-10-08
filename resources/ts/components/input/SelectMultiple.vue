<template>
    <v-select
        :value="value"
        :items="options"
        :label="label"
        :error-messages="errors"
        chips
        multiple
        v-bind="bind_parameters"
        @input="value => $emit('input', value)"
    />
</template>

<script lang="ts">
import { Component, Prop } from 'vue-property-decorator';
import TextField from '@/components/input/TextField.vue';
import { Option } from '@/types/Inputs';

@Component
export default class SelectMultiple extends TextField {
    @Prop({ required: true }) protected options!: Option[];
}
</script>
