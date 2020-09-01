<template>
    <v-dialog
        :value="value"
        width="800px"
        @input="dialog => $emit('input', dialog ? value.id : 0)"
    >
        <v-card>
            <v-card-title>
                Add:
                <span
                    :class="{
                        'ml-3': true,
                        'text-decoration-underline': true,
                        'selected': type === movie_type
                    }"
                    style="cursor: pointer;"
                    @click="changeType(movie_type)"
                >
                    Movie
                </span>
                <span class="ml-3">/</span>
                <span
                    :class="{
                        'ml-3': true,
                        clickable: true,
                        'text-decoration-underline': true,
                        'selected': type !== movie_type
                    }"
                    style="cursor: pointer;"
                    @click="changeType(serie_type)"
                >
                    Serie
                </span>
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
import axios from '@/plugins/axios';

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

        return image.url.replace('http://', 'https://');
    }

    @Watch('search')
    onSearchChanged(): void {
        this.searchItem();
    }

    async put(): Promise<void> {
        // TODO remove headers for image
        // console.log(axios.get('https://artworks.thetvdb.com/banners/posters/269586-11.jpg', {headers: { Origin: '', Referer: ''}}));

        // if (this.selected) {
        //     this.requests.push(await putRequest(this.selected));
        //     this.$emit('input', false);
        // }
    }
    async searchItem(): Promise<void> {
        if (! this.search) return;

        this.searching = true;
        try {
            this.results = await searchItem(this.search, this.type);
        } catch (error) {
            // Nothing
        }
        this.searching = false;
    }
    changeType(type: ItemType): void {
        this.type = type;
        this.search = '';
        this.selected = null;
        this.results = [];
    }
}
</script>