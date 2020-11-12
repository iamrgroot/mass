<template>
    <v-tooltip
        :bottom="bottom"
        :right="right"
        :left="left"
        :top="top"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-img
                contain
                :src="src"
                :max-height="height"
                :max-width="width"
                v-bind="attrs"
                v-on="on"
            />
        </template>
        <v-img
            contain
            :src="src"
            max-height="500"
            max-width="250"
        />
    </v-tooltip>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api';

export default defineComponent({
    props: {
        date: {
            type: String,
            required: true,
        },
        src: {
            required: true,
            type: String,
        },
        height: {
            default: 50,
            type: [String, Number],
        },
        width: {
            default: 50,
            type: [String, Number],
        },
        bottom: {
            default: false,
            type: Boolean,
        },
        right: {
            default: false,
            type: Boolean,
        },
        left: {
            default: false,
            type: Boolean,
        },
        top: {
            default: false,
            type: Boolean,
        },
    },
});
</script>