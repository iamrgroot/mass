<template>
    <v-dialog
        v-model="dialog"
        width="800px"
    >
        <v-card :loading="loading">
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
                    :items="profiles"
                    item-value="id"
                    item-text="name"
                    @input="value => updateProfile({item_type: item.type, item_id: item.id, profile_id: value})"
                />
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    text
                    @click="dialog = false"
                >
                    Close
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { namespace } from 'vuex-class';
import { Item, Profile } from '@/types/Item';
import { ChangeProfileArgument } from '@/types/Args';
import { profile_store } from '@/store/profiles';
import { ItemType } from '@/enums/ItemType';

const Items = namespace('Items');

@Component
export default class ProfileDialog extends Vue {
    get profiles(): Profile[] {
        if (! this.item) return [];

        return this.item.type === ItemType.Movie ?
            profile_store.movie_profiles :
            profile_store.serie_profiles;
    }

    get dialog(): boolean {
        return profile_store.dialog;
    }
    set dialog(dialog: boolean) {
        profile_store.dialog = dialog;
    }

    get loading(): boolean {
        return profile_store.loading;
    }

    @Items.State private item!: Item | null;

    @Items.Action private updateProfile!: (args: ChangeProfileArgument) => void;
}
</script>