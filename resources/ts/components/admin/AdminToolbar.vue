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
import { Component, Vue } from 'vue-property-decorator';
import ToolbarButton from '@/components/defaults/ToolbarButton.vue';

@Component({
    components: {
        ToolbarButton
    }
})
export default class AdminToolbar extends Vue {
    logout(): void {
        window.location.replace(window.location.protocol + '//' + window.location.host + '/logout');
    }
    maintenance(): void {
        window.location.replace(window.location.protocol + '//' + window.location.host + '/maintenance/users');
    }
}
</script>