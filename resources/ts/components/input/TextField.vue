<template>
    <v-text-field
        :value="value"
        :label="label"
        :error-messages="errors"
        v-bind="bind_parameters"
        @input="value => $emit('input', value)"
    />
</template>

<script lang="ts">
import { computed, defineComponent, watch } from '@vue/composition-api';

export default defineComponent({
    props: {
        value: {
            type: [String, Number, Boolean],
            required: true,
            validator: (): boolean => true,
        },
        label: {
            type: String,
            default: '',
        },
        bind_parameters: {
            type: Object,
            // eslint-disable-next-line @typescript-eslint/no-explicit-any
            default: (): Record<string, any> => ({}),
        },
        errors: {
            type: Array,
            default: (): string[] => [],
        },
        success: {
            type: Boolean,
            default: false,
        },
        error: {
            type: Boolean,
            default: false,
        },
    },
    setup(props, vm) {
        const append_icon = computed((): string => {
            if (props.success) {
                return '$mdiCheck';
            }

            if (props.error) {
                return '$mdiClose';
            }

            return '';
        });

        watch(() => props.success, () => {
            if (! props.success) {
                return;
            }

            setTimeout(() => {
                vm.emit('update:success', false);
            }, 3000);
        });

        watch(() => props.error, () => {
            if (! props.error) {
                return;
            }

            setTimeout(() => {
                vm.emit('update:error', false);
            }, 3000);
        });

        return { append_icon };
    },
});
</script>
