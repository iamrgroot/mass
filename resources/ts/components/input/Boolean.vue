<template>
    <v-switch
        :input-value="value"
        :label="label"
        :error-messages="errors"
        :success="success"
        :error="error"
        :append-icon="append_icon"
        v-bind="bind_parameters"
        @change="value => $emit('input', value)"
    />
</template>

<script lang="ts">
import { Component } from 'vue-property-decorator';
import TextField from '@/components/input/TextField.vue';

@Component
export default class Boolean extends TextField {}
</script>