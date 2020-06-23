<template>
    <div>
        <v-toolbar max-height="64">
            <v-toolbar-title>
                <v-icon>$mdiHome</v-icon>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-toolbar-items>
                <v-btn text small to="/torrents">Torrents</v-btn>
                <v-btn text small to="/movies">Movies</v-btn>
                <v-btn text small to="/series">Series</v-btn>
                <v-btn text small @click="logout">Log out</v-btn>
            </v-toolbar-items>
        </v-toolbar>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { namespace } from 'vuex-class';
import NotificationComponent from "@/components/defaults/Notification.vue";
import { Notification } from '../../types/Notification';

const Notifications = namespace('Notifications');

@Component({
    components: {
        NotificationComponent
    }
})
export default class Toolbar extends Vue {

    @Notifications.State private notifications!: Array<Notification>;

    @Notifications.Mutation private remove!: (notification_id: number) => void;

    logout(): void {
        window.location.replace(window.location.protocol + '//' + window.location.host + '/logout');
    }
}
</script>