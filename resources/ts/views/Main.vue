<template>
    <v-main>
        <v-fade-transition mode="out-in">
            <router-view :key="$route.path" />
        </v-fade-transition>

        <v-fade-transition>
            <NotificationComponent
                v-if="notifications.length > 0"
                :key="notifications[0].id"
                :notification="notifications[0]"
                :total="notifications.length"
                @closed="removeNotification(notifications[0].id)"
            />
        </v-fade-transition>

        <confirm ref="confirm" />
    </v-main>
</template>

<style lang="scss">
    @import '../../../node_modules/typeface-roboto/index.css';
</style>

<script lang="ts">
import { defineComponent } from '@vue/composition-api';

import Confirm from '@/components/defaults/Confirm.vue';
import NotificationComponent from '@/components/defaults/Notification.vue';

import { ConfirmType } from '@/types/ConfirmOptions';

import { useNotifications } from '@/store/notifications';

export default defineComponent({
    components: {
        Confirm,
        NotificationComponent,
    },
    setup() {
        const { notifications, removeNotification } = useNotifications();

        return {
            notifications,
            removeNotification,
        };
    },
    mounted() {
        this.$root.$confirm = (this.$refs.confirm as Vue & { open: ConfirmType}).open;
    }
});
</script>
