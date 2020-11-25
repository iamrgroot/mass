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
import { defineComponent } from '@vue/composition-api';

import TextField from '@/components/input/TextField.vue';

export default defineComponent({
    extends: TextField
});
</script>