<template>
    <div>
        <v-toolbar max-height="64">
            <v-toolbar-items>
                <v-btn
                    text
                    small
                    @click="home"
                >
                    Home
                </v-btn>
            </v-toolbar-items>
            <v-spacer />

            <v-toolbar-title>Maintenance</v-toolbar-title>

            <v-spacer />
            <v-toolbar-items>
                <v-btn
                    v-for="route in routes"
                    :key="route"
                    text
                    small
                    :to="`/maintenance/${route}`"
                >
                    {{ route | capitalize }}
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
import { capitalize } from '@/filters/filters';

@Component({
    filters: {
        capitalize
    }
})
export default class Toolbar extends Vue {
    get routes(): string[] {
        return Object.keys(window.injected);
    }
    logout(): void {
        window.location.replace(window.location.protocol + '//' + window.location.host + '/logout');
    }
    home(): void {
        window.location.replace(window.location.protocol + '//' + window.location.host);
    }
}
</script>