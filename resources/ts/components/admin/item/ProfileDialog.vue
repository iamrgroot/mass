<template>
    <v-dialog
        :value="dialog"
        width="800px"
        @input="value => setProfileDialog(value)"
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
                    @click="setProfileDialog(false)"
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

const Items = namespace('Items');
const Profiles = namespace('Profiles');

@Component
export default class ProfileDialog extends Vue {
    @Profiles.State private profiles!: Profile[];
    @Profiles.State private dialog!: boolean;
    @Profiles.State private loading!: boolean;

    @Items.State private item!: Item | null;

    @Profiles.Action private updateProfile!: (args: ChangeProfileArgument) => void;
    @Profiles.Mutation private setProfileDialog!: (dialog: boolean) => void;

// @Indexers.Action private manualSearch!: (args: ItemTypeArgument) => Promise<boolean>;
}
</script>