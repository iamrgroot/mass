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
import { defineComponent } from '@vue/composition-api';

import TextField from '@/components/input/TextField.vue';

export default defineComponent({
    extends: TextField,
    props: {
        options: {
            type: Array,
            required: true,
        }
    },
});
</script>
