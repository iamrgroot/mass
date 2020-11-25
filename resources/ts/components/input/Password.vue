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
import { defineComponent } from '@vue/composition-api';

import TextField from '@/components/input/TextField.vue';

export default defineComponent({
    extends: TextField,
    data() {
        return {
            show: false,
        };
    },
});
</script>
