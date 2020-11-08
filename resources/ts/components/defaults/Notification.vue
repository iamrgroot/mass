<template>
    <v-snackbar
        v-model="snackbar"
        :color="notification.color"
        :timeout="notification.timeout"
        height="200px"
    >
        <template v-if="! notification.content">
            {{ notification.title }}
        </template>
        <v-row
            v-else
            no-gutters
        >
            <v-col cols="12">
                <span class="title">{{ notification.title }}</span>
            </v-col>
            <v-col cols="12">
                {{ notification.content }}
            </v-col>
        </v-row>
        <template v-slot:action="{ attrs }">
            <v-btn
                v-bind="attrs"
                text
                color="white"
                @click="snackbar = false"
            >
                {{ total > 1 ? `(1/${total})` : 'close' }}
            </v-btn>
        </template>
    </v-snackbar>
</template>

<script lang="ts">
import { defineComponent, ref, watch } from '@vue/composition-api';

export default defineComponent({
    props: {
        notification: {
            type: Notification,
            required: true,
        },
        total: {
            required: true,
            type: Number,
        },
    },
    setup(props, vm) {
        const snackbar = ref(true);

        watch(snackbar, () => {
            if (! snackbar.value) vm.emit('closed');
        });

        return {
            snackbar,
        };
    }
});
</script>