<template>
    <div>
        <v-card
            :loading="loading"
            class="ma-3"
        >
            <v-card-title>
                <span>System</span>
                <v-spacer />
                <v-icon
                    @click="settings_dialog = true"
                >
                    $mdiCog
                </v-icon>
            </v-card-title>
            <v-divider class="mx-3" />
            <v-card-text>
                test
            </v-card-text>
        </v-card>

        <settings-bottom-sheet />
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { system_store } from '@/store/system';
import { Setting } from '@/types/System';

import SettingsBottomSheet from '@/components/admin/system/SettingsBottomSheet.vue';

@Component({
    components: {
        SettingsBottomSheet,
    }
})
export default class SystemPage extends Vue {
    private loading = false;

    get settings(): Setting[] {
        return system_store.settings;
    }
    set settings(settings: Setting[]) {
        system_store.settings = settings;
    }
    get settings_dialog(): boolean {
        return system_store.settings_dialog;
    }
    set settings_dialog(settings_dialog: boolean) {
        system_store.settings_dialog = settings_dialog;
    }
}
</script>