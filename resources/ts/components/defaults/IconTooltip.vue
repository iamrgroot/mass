<template>
    <v-tooltip bottom>
        <template v-slot:activator="{ on, attrs }">
            <v-icon
                :color="color"
                v-bind="attrs"
                v-on="on"
            >
                {{ icon }}
            </v-icon>
        </template>
        <span>{{ text }}</span>
    </v-tooltip>
</template>


<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class Confirm extends Vue {
    @Prop({required: true}) private icon!: string;
    @Prop({required: true}) private text!: string;
    @Prop({default: ''}) private color!: string;
}
</script>