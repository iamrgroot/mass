<template>
    <div>
        <v-toolbar max-height="64">
            <v-spacer />

            <v-toolbar-items>
                <v-btn
                    text
                    small
                    to="/torrents"
                >
                    Torrents
                </v-btn>
                <v-btn
                    text
                    small
                    to="/movies"
                >
                    Movies
                </v-btn>
                <v-btn
                    text
                    small
                    to="/series"
                >
                    Series
                </v-btn>
                <v-btn
                    icon
                    @click="logout"
                >
                    <v-icon>$mdiLogout</v-icon>
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>
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