<template>
    <div>
        <v-toolbar max-height="64">
            <v-toolbar-title>
                <v-icon>mdi-home</v-icon>
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <v-toolbar-items>
                <v-btn text small to="/movies">Movies</v-btn>
                <v-btn text small to="/series">Series</v-btn>
                <v-btn text small @click="logout">Log out</v-btn>
            </v-toolbar-items>
        </v-toolbar>

        <!-- <notification
            v-if="notifications.length > 0"
            :key="notifications[0].id"
            :notification="notifications[0]"
            :total="notifications.length"
            @closed="remove(notifications[0].id)"
        /> -->
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class Toolbar extends Vue {
    logout(): void {
        window.location.replace(window.location.protocol + '//' + window.location.host + '/logout');
    }
}
</script>