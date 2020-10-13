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
                @closed="remove(notifications[0].id)"
            />
        </v-fade-transition>

        <confirm ref="confirm" />
    </v-main>
</template>

<style lang="scss">
    @import '../../../node_modules/typeface-roboto/index.css';
</style>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { namespace } from 'vuex-class';
import Confirm from '@/components/defaults/Confirm.vue';
import NotificationComponent from '@/components/defaults/Notification.vue';
import { Notification } from '@/types/Notification';

const Notifications = namespace('Notifications');

@Component({
    components: {
        Confirm,
        NotificationComponent,
    }
})
export default class Main extends Vue {
    @Notifications.State private notifications!: Notification[];
    @Notifications.Mutation private remove!: (notification_id: number) => void;

    mounted(): void {
        this.$root.$confirm = (this.$refs.confirm as Confirm).open;
    }
}
</script>
