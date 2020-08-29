<template>
    <v-text-field
        :value="value"
        :label="label"
        :type="show ? 'text' : 'password'"
        :error-messages="errors"
        v-bind="bind_parameters"
        @input="value => $emit('input', value)"
    />
</template>

<script lang="ts">
import { Component } from 'vue-property-decorator';
import TextField from '@/components/input/TextField.vue';

@Component
export default class Password extends TextField {
    protected show = false;
}
</script>
