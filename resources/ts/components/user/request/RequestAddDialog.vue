<template>
    <v-dialog
        :value="value"
        width="800px"
        @input="dialog => $emit('input', dialog ? value.id : 0)"
    >
        <v-card>
            <v-card-title>
                Add:
                <v-btn-toggle
                    v-model="type"
                    mandatory
                    color="primary"
                    borderless
                    class="ml-5"
                    @change="changeType()"
                >
                    <v-btn :value="movie_type">
                        <span class="hidden-sm-and-down">Movie</span>
                        <v-icon right>
                            $mdiMovie
                        </v-icon>
                    </v-btn>
                    <v-btn :value="serie_type">
                        <span class="hidden-sm-and-down">Series</span>
                        <v-icon right>
                            $mdiTelevision
                        </v-icon>
                    </v-btn>
                </v-btn-toggle>
            </v-card-title>
            <v-card-text>
                <v-row no-gutters>
                    <v-col cols="8">
                        <v-autocomplete
                            v-model="selected"
                            :items="results"
                            :loading="searching"
                            :search-input.sync="search"
                            item-text="text"
                            item-value="tmdb_id"
                            label="Search"
                            placeholder="Start typing"
                            prepend-icon="$mdiDatabaseSearch"
                            return-object
                            class="pr-2"
                            clearable
                        />
                    </v-col>
                    <v-col
                        cols="4"
                        align-self="center"
                    >
                        <v-img
                            :src="image_url"
                            max-height="200"
                            max-width="100%"
                            contain
                        />
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    color="success"
                    :disabled="! selected"
                    text
                    @click="put"
                >
                    Add
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<style lang="scss" scoped>
    .selected {
        color: var(--v-primary-base);
    }
</style>

<script lang="ts">
import { Component, Vue, Prop, Watch } from 'vue-property-decorator';
import { request_store } from '@/store/request';
import { Request } from '@/types/Requests';
import { ItemType } from '@/enums/ItemType';
import { SearchResult } from '@/types/Item';
import { searchItem } from '@/api/items';
import { getImageURL } from '@/helpers/images';
import { putRequest } from '@/api/request';
import find from 'lodash/find';

@Component
export default class RequestAddDialog extends Vue {
    @Prop({ required: true }) private value!: boolean;

    private type = 0;
    private searching = false;
    private search = '';
    private results: SearchResult[] = [];
    private selected: SearchResult | null = null;

    get movie_type(): ItemType {
        return ItemType.Movie;
    }
    get serie_type(): ItemType {
        return ItemType.Serie;
    }
    get requests(): Request[] {
        return request_store.requests;
    }
    get image_url(): string {
        const shiba = '/images/shiba_poster.jpg';

        if (! this.selected) {
            return shiba;
        }

        const image = this.selected.images.find(image => image.coverType === 'poster');

        if (! image) {
            return shiba;
        }

        return getImageURL(this.type, image.url);
    }

    @Watch('search')
    onSearchChanged(): void {
        this.searchItem();
    }

    async put(): Promise<void> {
        if (this.selected) {
            this.requests.push(await putRequest(this.selected));
            this.$emit('input', false);
        }
    }
    async searchItem(): Promise<void> {
        if (! this.search) return;

        this.searching = true;
        try {
            const results = await searchItem(this.search, this.type);

            const search = this.type === ItemType.Movie ? 'tmdb_id' : 'tvdb_id';

            this.results = results.filter(result => ! find(this.requests, {type: this.type, item_id: result[search]}));
        } catch (error) {
            // Nothing
        }
        this.searching = false;
    }
    changeType(): void {
        this.search = '';
        this.selected = null;
        this.results = [];
    }
}
</script>