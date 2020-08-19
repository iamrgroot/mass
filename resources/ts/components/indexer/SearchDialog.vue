<template>
    <v-dialog
        v-model="dialog"
        :loading="loading"
        width="600px"
    >
        <v-card>
            <v-card-title>
                <span class="headline">
                    Search Jackett
                </span>
            </v-card-title>
            <v-card-text>
                Test
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    text
                    @click="setDialog(false)"
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
import { ItemTypeArgument } from '@/types/Args';

const Indexers = namespace('Indexers');

@Component
export default class SearchDialog extends Vue {
    @Indexers.State private dialog!: boolean;
    @Indexers.State private loading!: boolean;

    @Indexers.Mutation private setDialog!: (dialog: boolean) => void;

    @Indexers.Action private manualSearch!: (args: ItemTypeArgument) => Promise<boolean>;
}
</script>