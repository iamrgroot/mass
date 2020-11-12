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
import { defineComponent } from '@vue/composition-api';

import Boolean from '@/components/input/Boolean.vue';
import SelectMovieProfile from '@/components/input/SelectMovieProfile.vue';
import SelectSerieProfile from '@/components/input/SelectSerieProfile.vue';

import { getSettings, updateSetting } from '@/api/system';

import { useSystem } from '@/store/system';
import { Setting } from '@/types/System';

export default defineComponent({
    components: {
        Boolean,
        SelectMovieProfile,
        SelectSerieProfile,
    },
    setup() {
        const { settings, settings_dialog } = useSystem();

        const settingChanged = async (setting: Setting): Promise<void> => {
            setting.updating = true;

            try {
                await updateSetting(setting.name, setting.value);
                setting.success = true;
            } catch (error) {
                setting.value = setting.previous_value;
                setting.error = true;
            }

            setting.updating = false;
        };

        return {
            settings,
            settings_dialog,
            settingChanged,
        };
    },
    async created() {
        this.settings = await getSettings();
    },
});
</script>