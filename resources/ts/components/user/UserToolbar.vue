<template>
    <div v-if="show_toolbar">
        <v-toolbar
            v-if="! $vuetify.breakpoint.mobile"
            max-height="64"
        >
            <v-spacer />

            <v-toolbar-items>
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
            <v-spacer />
            <v-btn
                icon
                @click="logout"
            >
                <v-icon>$mdiLogout</v-icon>
            </v-btn>
        </v-bottom-navigation>
    </div>
</template>

<script lang="ts">
import { useToolbar } from '@/store/toolbar';
import { defineComponent } from '@vue/composition-api';

export default defineComponent({
    setup() {
        const { show_toolbar } = useToolbar();

        const logout = (): void => {
            window.location.replace(window.location.protocol + '//' + window.location.host + '/logout');
        };

        return {
            show_toolbar,
            logout,
        };
    }
});
</script>