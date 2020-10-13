<template>
    <div>
        <v-toolbar max-height="64">
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
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component
export default class UserToolbar extends Vue {
    logout(): void {
        window.location.replace(window.location.protocol + '//' + window.location.host + '/logout');
    }
}
</script>