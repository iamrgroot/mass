<template>
    <v-card
        min-width="100%"
    >
        <v-card-text>
            <v-row
                no-gutters
                align="center"
            >
                <v-col cols="6">
                    <v-autocomplete
                        v-model="selected"
                        :items="results"
                        :loading="loading"
                        :search-input.sync="search"
                        item-text="title"
                        item-value="tmdbId"
                        label="Add Item"
                        placeholder="Start typing"
                        prepend-icon="mdi-database-search"
                        return-object
                        cache-items
                        :error-messages="add_errors"
                        class="pr-2"
                    ></v-autocomplete>
                </v-col>
                <v-col cols="2">
                    <v-select
                        v-model="selected_profile"
                        :items="profiles"
                        item-text="name"
                        item-value="id"
                        label="Profile"
                        class="px-2"
                    ></v-select>
                </v-col> 
                <v-col cols="2">
                    <v-select
                        v-if="! is_movie && selected !== null"
                        v-model="selected_seasons"
                        :items="selected.seasons"
                        multiple
                        item-text="seasonNumber"
                        item-value="seasonNumber"
                        label="Seasons"
                        class="px-2"
                    ></v-select>
                </v-col>
                <v-col cols="1" class="text-center">
                    <v-btn 
                        icon
                        v-if="selected !== null"
                        @click="add"
                    >
                        <v-icon>
                            mdi-database-plus
                        </v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
import { Component, Vue, Prop, Watch } from 'vue-property-decorator';
import { namespace } from 'vuex-class'
import { Item } from '@/types/item';
import { Profile } from '@/types/profile';
import { ItemType } from '@/enums/ItemType';
import { AxiosResponse } from 'axios';
import axios from "@/plugins/axios";

type Season = {
    monitored: boolean
    seasonNumber: number
}

type SearchResult = {
    id: number,
    seasons?: Array<Season>,
}

const Profiles = namespace('Profiles');
const Items = namespace('Items');

@Component
export default class Add extends Vue {
    @Prop({ required: true }) private type!: number;

    private results: Array<SearchResult> = [];
    private search = '';
    // private search_axios: 
    private selected: SearchResult | null = null;
    private selected_profile: number | null = null;
    private selected_seasons: Array<number> = [];

    get loading(): boolean { return false /*this.search_axios !== null;*/ }
    get is_movie(): boolean { return this.type === ItemType.Movie; }
    get search_url(): string { return this.is_movie ? '/search_movies' : '/search_series'; }
    
    @Profiles.State public profiles!: Array<Profile>;
    @Profiles.Action public fetchProfiles!: (type: ItemType) => Promise<AxiosResponse>;

    @Items.State public add_errors!: Array<string>;
    @Items.State public adding!: boolean;
    @Items.Action public addItem!: (item: Item, profile: number, seasons: Array<number>|null, type: ItemType) => Promise<Item>

    @Watch('selected.seasons') 
    onSeasonsChanged() {
        if (this.selected?.seasons) {
            this.selected_seasons = this.selected.seasons.map(item => item.seasonNumber);
        }
    }
    @Watch('search')
    onSearchChange(value: string) {
        this.doSearch();
    }


    created() {
        this.fetchProfiles(this.type).finally(() => {
            if (this.profiles.length > 0) this.selected_profile = this.profiles[0].id;
        });
    }


    doSearch() {
        if (this.search === '') return;

        // if (this.search_axios !== null) this.search_axios.cancel();

        // this.search_axios = window.axios.CancelToken.source();

        axios.get(this.search + this.search_url, {
            // cancelToken: this.search_axios.token
        }).then(({ data }) => {
            this.results = data;
        }).finally(() => {
            // this.search_axios = null;
        });
    }
    add() {
        if (this.selected === null || this.selected_profile === null) return;

        this.addItem(
            this.selected,
            this.selected_profile,
            this.selected_seasons,
            this.type
        );
    }
}
</script>
