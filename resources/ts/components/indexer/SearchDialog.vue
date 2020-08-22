<template>
    <v-dialog
        :value="dialog"
        width="800px"
        @input="value => setDialog(value)"
    >
        <v-card :loading="loading">
            <v-card-title>
                <v-row justify="space-between">
                    <span class="headline">
                        Search Jackett
                    </span>
                    <v-icon
                        @click="manualSearch({
                            item_id: item.id,
                            type: item.type
                        })"
                    >
                        $mdiRefresh
                    </v-icon>
                </v-row>
            </v-card-title>
            <v-card-text>
                <v-data-table
                    :headers="headers"
                    :items="indexer_results"
                    :items-per-page="15"
                    :sort-by="[ 'seeders', 'size' ]"
                    :sort-desc="[ true, true ]"
                >
                    <template #[`item.age`]="{ value }">
                        {{ value }}d
                    </template>
                    <template #[`item.size`]="{ value }">
                        {{ value | byte }}
                    </template>
                    <template #[`item.rejections`]="{ value }">
                        <v-tooltip
                            bottom
                            color="error"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    v-if="value.length > 0"
                                    color="error"
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    $mdiInformation
                                </v-icon>
                            </template>
                            <div
                                v-for="(item, index) in value"
                                :key="index"
                            >
                                <v-row>
                                    {{ item }}
                                </v-row>
                            </div>
                        </v-tooltip>
                    </template>
                    <template #[`item.actions`]="{ item }">
                        <v-icon
                            color="success"
                            @click="addManual({
                                guid: item.guid,
                                indexer_id: item.indexer_id,
                                type: store_item.type
                            })"
                        >
                            $mdiCloudDownload
                        </v-icon>
                    </template>
                </v-data-table>
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
import { ItemTypeArgument, ManualAddArgument } from '@/types/Args';
import { IndexResult, Item } from '@/types/Item';
import { byte } from '@/filters/filters';

const Indexers = namespace('Indexers');
const Items = namespace('Items');

@Component({
    filters: {
        byte: byte,
    }
})
export default class SearchDialog extends Vue {
    private headers = [
        { text: 'quality', value: 'quality' },
        { text: 'age', value: 'age' },
        { text: 'seeders', value: 'seeders' },
        { text: 'leechers', value: 'leechers' },
        { text: 'size', value: 'size' },
        { text: 'rejections', value: 'rejections', align: 'center' },
        { text: '', value: 'actions', align: 'right', sortable: false },
    ];

    @Items.State private item!: Item | null;

    @Indexers.State private dialog!: boolean;
    @Indexers.State private loading!: boolean;
    @Indexers.State private indexer_results!: IndexResult[];

    @Indexers.Mutation private setDialog!: (dialog: boolean) => void;

    @Indexers.Action private manualSearch!: (args: ItemTypeArgument) => Promise<boolean>;
    @Indexers.Action private addManual!: (args: ManualAddArgument) => Promise<boolean>;

    private get store_item(): Item | null {
        return this.item;
    }
}
</script>