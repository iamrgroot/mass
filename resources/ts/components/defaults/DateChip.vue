<template>
    <v-badge
        :content="date_object.toLocaleTimeString(locale, time_options)"
        bordered
        overlap
    >
        <v-chip label>
            <span class="pr-1">{{ date_object.toLocaleDateString(locale) }}</span>
        </v-chip>
    </v-badge>
</template>


<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { locale_store, short_time_options } from '@/store/locale';

@Component
export default class DateChip extends Vue {
    @Prop({required: true}) private date!: string;

    get time_options(): Intl.DateTimeFormatOptions {
        return short_time_options;
    }
    get locale(): string {
        return locale_store.locale;
    }
    get date_object(): Date | null {
        try {
            return new Date(this.date);
        } catch (error) {
            return null;
        }
    }
}
</script>