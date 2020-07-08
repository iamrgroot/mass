<template>
    <v-btn
        icon
        class="ma-1"
        @click="$emit('click')"
    >
        <v-icon>
            {{ icon }}
        </v-icon>
    </v-btn>
</template>


<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class Confirm extends Vue {
    @Prop({required: true}) private icon!: string;
}
</script>