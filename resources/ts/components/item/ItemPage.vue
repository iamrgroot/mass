<template>
    <v-card
        :loading="single_loading"
        class="ma-3"
    >
        <template v-if="! single_loading">
            <v-card-title>
                {{ item.title }}
                <v-spacer />
                <v-btn
                    icon
                    class="ma-2"
                    @click="fetch"
                >
                    <v-icon>
                        mdi-refresh
                    </v-icon>
                </v-btn>
                <v-btn 
                    icon
                    color="error"
                    @click="remove"
                >
                    <v-icon>
                        mdi-delete
                    </v-icon>
                </v-btn>
            </v-card-title>
            <v-divider class="mx-3" />
            <v-card-text >
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
import { Item } from '@/types/Item';
import { ItemType } from '@/enums/ItemType';
import ItemBase from '@/components/item/ItemBase.vue';
import SeasonsButton from '@/components/item/SeasonsButton.vue';

const Items = namespace('Items');

@Component({
    components: {
        SeasonsButton
    }
})
export default class ItemPage extends ItemBase {

    get is_movie(): boolean { return this.$route.name === 'movie' }
    get item_type(): ItemType { return this.is_movie ? ItemType.Movie : ItemType.Serie }
    get redirect(): Location { return { name: this.is_movie ? 'movies' : 'series'} }

    @Items.State private item?: Item;
    @Items.State private single_loading!: boolean;

    @Items.Action private fetchSingle!: (args: ItemTypeArgument) => Promise<Item>;
    @Items.Action private delete!: (args: ItemTypeArgument) => Promise<boolean>;

    created() {
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
            if(! confirmed || ! this.item) {
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