<template>
    <v-dialog
        v-model="profile_dialog"
        width="800px"
    >
        <v-card :loading="profiles_loading">
            <v-card-title>
                <v-row justify="space-between">
                    <span class="headline">
                        Profile
                    </span>
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-select
                    v-if="item"
                    :value="item.profile_id"
                    :items="relevant_profiles"
                    item-value="id"
                    item-text="name"
                    @input="value => updateItemProfile(item.type, item.id, value)"
                />
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    text
                    @click="profile_dialog = false"
                >
                    Close
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api';
import { useProfiles } from '@/store/profiles';
import { useItems } from '@/store/items';

export default defineComponent({
    setup() {
        const { profiles_loading, profile_dialog, relevant_profiles, } = useProfiles();
        const { item, updateItemProfile } = useItems();

        return {
            profiles_loading,
            profile_dialog,
            relevant_profiles,
            item,
            updateItemProfile,
        };
    }
});
</script>