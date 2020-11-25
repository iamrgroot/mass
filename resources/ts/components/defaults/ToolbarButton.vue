<template>
    <v-btn
        text
        small
        :to="`/${route}`"
    >
        {{ capitalize(route) }}
    </v-btn>
</template>


<script lang="ts">
import { defineComponent } from '@vue/composition-api';

import { capitalize } from '@/filters/filters';

export default defineComponent({
    props: {
        route: {
            type: String,
            required: true,
        },
    },
    setup() {
        return {
            capitalize,
        };
    }
});
</script>