<template>
    <v-dialog
        v-model="dialog"
        :max-width="options.width"
        :style="{ zIndex: options.zIndex }"
        @keydown.esc="cancel"
    >
        <v-card>
            <v-toolbar
                :color="options.color"
                dense
                flat
            >
                <v-toolbar-title>
                    {{ title }}
                </v-toolbar-title>
            </v-toolbar>
            <v-card-text
                v-show="message !== ''"
                class="pa-4"
            >
                {{ message }}
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    color="success darken-1"
                    text
                    @click.native="agree"
                >
                    Yes
                </v-btn>
                <v-btn
                    color="error darken-1"
                    text
                    @click.native="cancel"
                >
                    No
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script lang="ts">
import { defineComponent, reactive, toRefs } from '@vue/composition-api';

import { ConfirmOptions } from '@/types/ConfirmOptions';

export default defineComponent({
    setup() {
        const confirm_store = reactive({
            dialog: false,
            resolve: undefined as undefined | ((argument: boolean) => void),
            message: '',
            title: '',
            options: {
                color: 'white',
                width: 290,
                zIndex: 200
            } as ConfirmOptions
        });

        const open = (title: string, message?: string, options?: ConfirmOptions): Promise<boolean> => {
            confirm_store.dialog = true;
            confirm_store.title = title;

            confirm_store.message = message || '';
            confirm_store.options = Object.assign(confirm_store.options, options);

            return new Promise((resolve) => {
                confirm_store.resolve = resolve;
            });
        };
        const agree = (): void => {
            if (confirm_store.resolve !== undefined) confirm_store.resolve(true);
            confirm_store.dialog = false;
        };
        const cancel = (): void => {
            if (confirm_store.resolve !== undefined) confirm_store.resolve(false);
            confirm_store.dialog = false;
        };

        return {
            ...toRefs(confirm_store),
            open,
            agree,
            cancel,
        };
    }
});
</script>