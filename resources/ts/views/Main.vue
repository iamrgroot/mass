<template>
    <v-main
        :class="{
            'pa-3': show_toolbar && ! $vuetify.breakpoint.mobile,
            'mb-12': show_toolbar && $vuetify.breakpoint.mobile,
        }"
    >
        <keep-alive>
            <router-view :key="$route.path" />
        </keep-alive>

        <v-fade-transition>
            <notification
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
import Notification from '@/components/defaults/Notification.vue';

import { ConfirmType } from '@/types/ConfirmOptions';

import { useNotifications } from '@/store/notifications';
import { useToolbar } from '@/store/toolbar';

export default defineComponent({
    components: {
        Confirm,
        Notification,
    },
    setup() {
        const { notifications, removeNotification } = useNotifications();

        const { show_toolbar } = useToolbar();

        return {
            show_toolbar,
            notifications,
            removeNotification,
        };
    },
    mounted() {
        this.$root.$confirm = (this.$refs.confirm as Vue & { open: ConfirmType}).open;
    }
});
</script>
