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
                        item-text="text"
                        item-value="tmdb_id"
                        label="Add Item"
                        placeholder="Start typing"
                        prepend-icon="$mdiDatabaseSearch"
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
                <v-col 
                    v-if="! is_movie && selected !== null"
                    cols="2"
                >
                    <v-select
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
                        <v-icon>$mdiDatabaseSearch</v-icon>
                    </v-btn>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
import { Component, Vue, Prop, Watch } from 'vue-property-decorator';
import { namespace } from 'vuex-class'
import { Item, Profile, SearchResult } from '@/types/Item';
import { ItemAddArgument } from '@/types/Args';
import { ItemType } from '@/enums/ItemType';
import { AxiosResponse, CancelTokenSource } from 'axios';
import axios from "@/plugins/axios";

const Profiles = namespace('Profiles');
const Items = namespace('Items');

@Component
export default class Add extends Vue {
    @Prop({ required: true }) private type!: number;

    private results: Array<SearchResult> = [];
    private search = '';
    private search_axios: CancelTokenSource | null = null;
    private selected: SearchResult | null = null;
    private selected_profile: number | null = null;
    private selected_seasons: Array<number> = [];

    get loading(): boolean { return this.search_axios !== null; }
    get is_movie(): boolean { return this.type === ItemType.Movie; }
    get search_url(): string { return this.is_movie ? 'movies' : 'series'; }
    
    @Profiles.State private profiles!: Array<Profile>;
    @Profiles.Action private fetchProfiles!: (type: ItemType) => Promise<AxiosResponse>;

    @Items.State private add_errors!: Array<string>;
    @Items.State private adding!: boolean;
    @Items.Action private addItem!: (args: ItemAddArgument) => Promise<Item>

    @Watch('selected.seasons') 
    onSeasonsChanged() {
        if (this.selected?.seasons) {
            this.selected_seasons = this.selected.seasons.map(item => item.season_number);
        }
    }
    @Watch('search')
    onSearchChange() {
        this.doSearch();
    }


    async created() {
        await this.fetchProfiles(this.type);        

        if (this.profiles.length > 0) this.selected_profile = this.profiles[0].id;
    }


    doSearch() {        
        if (! this.search) return;

        if (this.search_axios !== null) this.search_axios.cancel();

        this.search_axios = axios.CancelToken.source();

        axios.get(`/async/${this.search_url}/${this.search}/search`, {
            cancelToken: this.search_axios.token
        }).then(({ data }) => {
            this.results = data;
        }).catch(() => {
            /** Do nothing when cancelled */
        }).finally(() => {
            this.search_axios = null;
        });
    }
    add() {
        if (this.selected === null || this.selected_profile === null) return;

        this.addItem({    
            item: this.selected,
            profile: this.selected_profile,
            seasons: this.selected_seasons,
            type: this.type
        });
    }
}
</script>
