<template>
    <div v-if="show_toolbar">
        <v-toolbar
            v-if="! $vuetify.breakpoint.mobile"
            max-height="64"
        >
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
        <v-bottom-navigation
            v-else
            fixed
        >
            <toolbar-button
                route="requests"
                icon="$mdiInboxArrowDown"
            />
            <toolbar-button
                route="movies"
                icon="$mdiMovie"
            />
            <toolbar-button
                route="series"
                icon="$mdiTelevision"
            />
            <v-spacer />
            <v-menu
                top
                offset-y
                close-on-click
            >
                <template #activator="{ on, attrs }">
                    <v-btn
                        icon
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>$mdiDotsVertical</v-icon>
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item to="torrents">
                        Torrents
                    </v-list-item>
                    <v-list-item to="system">
                        System
                    </v-list-item>
                    <v-list-item @click="logout">
                        <span class="red--text">Logout</span>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-bottom-navigation>
    </div>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api';

import { useToolbar } from '@/store/toolbar';

import ToolbarButton from '@/components/defaults/ToolbarButton.vue';

export default defineComponent({
    components: {
        ToolbarButton
    },
    setup() {
        const { show_toolbar } = useToolbar();

        const logout = (): void => {
            window.location.replace(window.location.protocol + '//' + window.location.host + '/logout');
        };
        const maintenance = (): void => {
            window.location.replace(window.location.protocol + '//' + window.location.host + '/maintenance/users');
        };

        return {
            show_toolbar,
            logout,
            maintenance,
        };
    }
});
</script>