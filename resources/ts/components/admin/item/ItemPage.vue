<template>
    <v-card
        :loading="single_loading"
        class="ma-3"
    >
        <template v-if="! single_loading">
            <v-card-title>
                {{ item.title }}
                <v-spacer />
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            class="ma-1"
                            v-bind="attrs"
                            v-on="on"
                            @click="searchIndexer({
                                item_id: item.id,
                                type: item.type
                            })"
                        >
                            <v-icon>$mdiMagnify</v-icon>
                        </v-btn>
                    </template>
                    <span>Search automagically</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            v-if="is_movie"
                            icon
                            class="ma-1"
                            v-bind="attrs"
                            v-on="on"
                            @click="manualSearch({
                                item_id: item.id,
                                type: item.type
                            })"
                        >
                            <v-icon>$mdiSearchWeb</v-icon>
                        </v-btn>
                    </template>
                    <span>Search manually</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            class="ma-1"
                            v-bind="attrs"
                            v-on="on"
                            @click="refresh({
                                item_id: item.id,
                                type: item.type
                            })"
                        >
                            <v-icon>$mdiRefresh</v-icon>
                        </v-btn>
                    </template>
                    <span>Refresh disk and info</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            class="ma-1"
                            color="error"
                            v-bind="attrs"
                            v-on="on"
                            @click="remove"
                        >
                            <v-icon>$mdiDelete</v-icon>
                        </v-btn>
                    </template>
                    <span>Delete</span>
                </v-tooltip>
            </v-card-title>
            <v-divider class="mx-3" />
            <v-card-text>
                <v-row class="ml-1">
                    <v-chip
                        v-for="(chip, index) in item.features"
                        :key="`chip_${index}`"
                        class="ma-1"
                        :color="chip.color"
                        label
                        small
                    >
                        {{ chip.text }}
                    </v-chip>
                    <v-spacer />
                    <SeasonsButton v-if="! is_movie" />
                    <v-btn
                        text
                        small
                        target="_blank"
                        :href="imdbLink(item)"
                        class="mx-1"
                    >
                        IMDb
                    </v-btn>
                </v-row>
                <v-row>
                    <v-col cols="10">
                        <v-row>
                            <v-col>
                                {{ item.overview }}
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="2">
                        <v-img
                            :src="imageLink(item)"
                            :lazy-src="static_image_location"
                            eager
                            contain
                            @error="() => {}"
                        />
                    </v-col>
                </v-row>
            </v-card-text>
        </template>

        <SearchDialog />
    </v-card>
</template>

<style lang="scss" scoped>
    a {
        color: black !important;
    }
</style>


<script lang="ts">
import { Component } from 'vue-property-decorator';
import { namespace } from 'vuex-class';
import { Location } from 'vue-router';
import { ItemTypeArgument } from '@/types/Args';
import { Item, IndexResult } from '@/types/Item';
import { ItemType } from '@/enums/ItemType';
import ItemBase from '@/components/admin/item/ItemBase.vue';
import SeasonsButton from '@/components/admin/item/SeasonsButton.vue';
import SearchDialog from '@/components/admin/indexer/SearchDialog.vue';

const Items = namespace('Items');
const Indexers = namespace('Indexers');

@Component({
    components: {
        SeasonsButton,
        SearchDialog
    }
})
export default class ItemPage extends ItemBase {

    get is_movie(): boolean { return this.$route.name === 'movie'; }
    get item_type(): ItemType { return this.is_movie ? ItemType.Movie : ItemType.Serie; }
    get redirect(): Location { return { name: this.is_movie ? 'movies' : 'series'}; }

    @Items.State private item?: Item;
    @Items.State private single_loading!: boolean;

    @Items.Action private fetchSingle!: (args: ItemTypeArgument) => Promise<Item>;
    @Items.Action private delete!: (args: ItemTypeArgument) => Promise<boolean>;
    @Items.Action private searchIndexer!: (args: ItemTypeArgument) => Promise<boolean>;
    @Items.Action private refresh!: (args: ItemTypeArgument) => Promise<boolean>;

    @Indexers.Action private manualSearch!: (args: ItemTypeArgument) => Promise<IndexResult[]>;

    created(): void {
        this.fetch();
    }

    fetch(): void {
        this.fetchSingle({
            item_id: Number(this.$route.params.id),
            type: this.item_type
        }).catch(() => {
            this.$router.push(this.redirect);
        });
    }
    remove(): void {
        const text = this.is_movie ? 'movie' : 'serie';

        this.$root.$confirm(`Delete ${text}?`).then(confirmed => {
            if (! confirmed || ! this.item) {
                return;
            }

            this.delete({
                item_id: this.item.id,
                type: this.item_type
            }).then(() => {
                this.$router.push(this.redirect);
            });
        });
    }
}
</script>