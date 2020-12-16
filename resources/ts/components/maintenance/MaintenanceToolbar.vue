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
                    {{ capitalize(route) }}
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
import { defineComponent } from '@vue/composition-api';

import { capitalize } from '@/filters/filters';

export default defineComponent({
    setup() {
        const routes = [] as string[]; // TODO Object.keys(window.injected);

        const logout = (): void => {
            window.location.replace(window.location.protocol + '//' + window.location.host + '/logout');
        };
        const home = (): void => {
            window.location.replace(window.location.protocol + '//' + window.location.host);
        };

        return {
            routes,
            logout,
            home,
            capitalize,
        };
    },
});
</script>