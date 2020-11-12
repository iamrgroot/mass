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
import { useLocale } from '@/store/locale';
import { computed, defineComponent } from '@vue/composition-api';

export default defineComponent({
    props: {
        date: {
            type: String,
            required: true,
        },
    },
    setup(props) {
        const date_object = computed((): Date | null => {
            try {
                return new Date(props.date);
            } catch (error) {
                return null;
            }
        });

        return {
            ...useLocale(),
            date_object,
        };
    }
});
</script>