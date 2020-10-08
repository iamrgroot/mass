<template>
    <v-dialog
        v-model="settings_dialog"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
    >
        <v-card rounded="0">
            <v-toolbar
                dark
                color="primary"
            >
                <v-toolbar-title>Settings</v-toolbar-title>
                <v-spacer />
                <v-btn
                    dark
                    icon
                    @click="settings_dialog = false"
                >
                    <v-icon>$mdiClose</v-icon>
                </v-btn>
            </v-toolbar>
            <v-card-text>
                <v-row
                    v-for="setting in settings"
                    :key="setting.name"
                >
                    <component
                        :is="setting.component"
                        v-model="setting.value"
                        :label="setting.name"
                        :success.sync="setting.success"
                        :error.sync="setting.error"
                        :bind_parameters="{
                            loading: setting.updating
                        }"
                        @input="settingChanged(setting)"
                    />
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { getSettings, updateSetting } from '@/api/system';
import { system_store } from '@/store/system';
import { Setting } from '@/types/System';

import Boolean from '@/components/input/Boolean.vue';
import SelectProfile from '@/components/input/SelectProfile.vue';

@Component({
    components: {
        Boolean,
        SelectProfile,
    }
})
export default class SettingsBottomSheet extends Vue {
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

    async created(): Promise<void> {
        this.settings = await getSettings();
    }

    async settingChanged(setting: Setting): Promise<void> {
        setting.updating = true;

        try {
            await updateSetting(setting.name, setting.value);
            setting.success = true;
        } catch (error) {
            setting.value = setting.previous_value;
            setting.error = true;
        }

        setting.updating = false;
    }
}
</script>