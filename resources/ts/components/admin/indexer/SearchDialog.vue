<template>
    <v-dialog
        :value="indexer_dialog"
        width="800px"
        @input="value => indexer_dialog = value"
    >
        <v-card :loading="indexer_loading">
            <v-card-title>
                <v-row justify="space-between">
                    <span class="headline">
                        Search Jackett
                    </span>
                    <v-icon
                        @click="searchIndexer(item.id, item.type)"
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
                            @click="addTorrentFromIndexer(item.guid, item.indexer_id, item.type)"
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
                    @click="indexer_dialog = false"
                >
                    Close
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api';
import { DataTableHeader } from 'vuetify';

import { byte } from '@/filters/filters';

import { useIndexers } from '@/store/indexers';
import { ItemType } from '@/enums/ItemType';
import { Item } from '@/types/Item';

export default defineComponent({
    setup() {
        const { 
            indexer_dialog,
            indexer_loading,
            indexer_results, 
            searchIndexers,
            addTorrentFromIndexer,
        } = useIndexers();

        const { headers } = useIndexerTable();

        const { item } = useItem();

        return {
            indexer_dialog,
            indexer_loading,
            indexer_results, 
            searchIndexers,
            addTorrentFromIndexer,
            headers,
            item,
        }
    }
})

function useItem() {
    // TODO get item from store
    const item = {
        type: ItemType.Movie,
        id: 1,
        rating: 1,
        image_url: '',
        imdb_id: '',
        profile_id: 1,
        features: [],
    } as Item;

    return {
        item,
    }
}

function useIndexerTable() {
    const headers = [
        { text: 'quality', value: 'quality' },
        { text: 'age', value: 'age' },
        { text: 'seeders', value: 'seeders' },
        { text: 'leechers', value: 'leechers' },
        { text: 'size', value: 'size' },
        { text: 'rejections', value: 'rejections', align: 'center' },
        { text: '', value: 'actions', align: 'right', sortable: false },
    ] as DataTableHeader[];

    return {
        headers,
    }
}
</script>