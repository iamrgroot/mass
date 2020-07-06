<template>
    <v-app>
        <toolbar />

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
    </v-app>
</template>

<style lang="scss">
    @import '../../../node_modules/typeface-roboto/index.css';
</style>

<script lang="ts">
import { Component, Vue, Watch } from 'vue-property-decorator';
import { namespace } from 'vuex-class';
import Toolbar from '@/components/navigation/Toolbar.vue';
import Confirm from '@/components/defaults/Confirm.vue';
import NotificationComponent from '@/components/defaults/Notification.vue';
import { Notification } from '@/types/Notification';
import { Route } from 'vue-router';

const Items = namespace('Items');
const Profiles = namespace('Profiles');
const Notifications = namespace('Notifications');

@Component({
    components: {
        Toolbar,
        Confirm,
        NotificationComponent,
    }
})
export default class Home extends Vue {
    @Notifications.State private notifications!: Array<Notification>;
    @Notifications.Mutation private remove!: (notification_id: number) => void;

    @Items.Mutation private resetItems!: () => void;

    @Profiles.Mutation private resetProfiles!: () => void;

    @Watch('$route')
    onRouteChanged(route: Route, old_route: Route): void {
        if (
            (route.name === 'movies' && old_route.name === 'series') ||
      (route.name === 'series' && old_route.name === 'movies')
        ) {
            this.resetItems();
            this.resetProfiles();
        }
    }

    mounted(): void {
        this.$root.$confirm = (this.$refs.confirm as Confirm).open;
    }
}
</script>
