<template>
    <v-tooltip bottom>
        <template #activator="{ on, attrs }">
            <v-icon
                :color="color"
                :style="{
                    cursor: has_click_listener ? 'pointer' : 'default'
                }"
                :class="classes"
                v-bind="attrs"
                v-on="on"
                @click="$emit('click')"
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
    @Prop({default: ''}) private classes!: string;

    get has_click_listener(): boolean {
        return !! this.$listeners && !! this.$listeners.click;
    }
}
</script>