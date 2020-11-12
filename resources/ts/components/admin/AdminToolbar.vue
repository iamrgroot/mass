<template>
    <div>
        <v-toolbar max-height="64">
            <v-toolbar-items>
                <v-btn
                    text
                    small
                    @click="maintenance"
                >
                    Maintenance
                </v-btn>
            </v-toolbar-items>

            <v-spacer />

            <v-toolbar-items>
                <toolbar-button route="system" />
                <toolbar-button route="requests" />
                <toolbar-button route="torrents" />
                <toolbar-button route="movies" />
                <toolbar-button route="series" />
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

import ToolbarButton from '@/components/defaults/ToolbarButton.vue';

export default defineComponent({
    components: {
        ToolbarButton
    },
    setup() {
        const logout = (): void => {
            window.location.replace(window.location.protocol + '//' + window.location.host + '/logout');
        };
        const maintenance = (): void => {
            window.location.replace(window.location.protocol + '//' + window.location.host + '/maintenance/users');
        };

        return {
            logout,
            maintenance,
        };
    }
});
</script>