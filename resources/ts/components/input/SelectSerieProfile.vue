<template>
    <v-select
        :value="value"
        :items="serie_profiles"
        :error-messages="errors"
        :label="label"
        item-value="id"
        item-text="name"
        chips
        v-bind="bind_parameters"
        @input="value => $emit('input', value)"
    />
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api';

import { useProfiles } from '@/store/profiles';

import TextField from '@/components/input/TextField.vue';

export default defineComponent({
    extends: TextField,
    setup() {
        const { serie_profiles } = useProfiles();

        return {
            serie_profiles,
        };
    },
});
</script>
