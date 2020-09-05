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
import { Component, Vue, Prop } from 'vue-property-decorator';

@Component
export default class ImagePreview extends Vue {
    @Prop({required: true}) private src!: string;
    @Prop({default: 50}) private height!: string | number;
    @Prop({default: 50}) private width!: string | number;
    @Prop({default: false}) private bottom!: boolean;
    @Prop({default: false}) private right!: boolean;
    @Prop({default: false}) private left!: boolean;
    @Prop({default: false}) private top!: boolean;
}
</script>