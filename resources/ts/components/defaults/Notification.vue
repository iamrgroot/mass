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
import { Component, Vue, Prop, Watch } from 'vue-property-decorator';
import { Notification } from '@/types/Notification';

@Component
export default class NotificationComponent extends Vue {
    @Prop({ required: true }) private notification!: Notification;
    @Prop({ required: true }) private total!: number;

    private snackbar = true;

    @Watch('snackbar')
    onSnackbarChanged(): void {
        if (! this.snackbar) this.$emit('closed');
    }
}
</script>