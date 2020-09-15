<template>
    <v-btn
        text
        small
        :to="`/${route}`"
    >
        {{ route | capitalize }}
    </v-btn>
</template>


<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { capitalize } from '@/filters/filters';

@Component({
    filters: {
        capitalize
    }
})
export default class ToolbarButton extends Vue {
    @Prop({required: true}) private route!: string;
}
</script>