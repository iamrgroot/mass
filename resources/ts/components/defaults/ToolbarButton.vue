<template>
    <v-btn
        text
        small
        :icon="!! icon"
        :to="`/${route}`"
    >
        <v-icon v-if="icon">
            {{ icon }}
        </v-icon>
        <span v-else>
            {{ capitalize(route) }}
        </span>
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
        icon: {
            type: String,
            default: '',
        }
    },
    setup() {
        return {
            capitalize,
        };
    }
});
</script>