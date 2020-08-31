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
                    />
                </v-col>
                <v-col cols="2">
                    <v-select
                        v-model="selected_profile"
                        :items="profiles"
                        item-text="name"
                        item-value="id"
                        label="Profile"
                        class="px-2"
                    />
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
                    />
                </v-col>
                <v-col
                    cols="1"
                    class="text-center"
                >
                    <v-btn
                        v-if="selected !== null"
                        icon
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
import { namespace } from 'vuex-class';
import { searchItem } from '@/api/items';
import { Item, Profile, SearchResult } from '@/types/Item';
import { ItemAddArgument } from '@/types/Args';
import { ItemType } from '@/enums/ItemType';
import { AxiosResponse } from 'axios';

const Profiles = namespace('Profiles');
const Items = namespace('Items');

@Component
export default class Add extends Vue {
    @Prop({ required: true }) private type!: number;

    private results: SearchResult[] = [];
    private search = '';
    private selected: SearchResult | null = null;
    private selected_profile: number | null = null;
    private selected_seasons: number[] = [];
    private loading = false;

    get is_movie(): boolean { return this.type === ItemType.Movie; }

    @Profiles.State private profiles!: Profile[];
    @Profiles.Action private fetchProfiles!: (type: ItemType) => Promise<AxiosResponse>;

    @Items.State private add_errors!: string[];
    @Items.State private adding!: boolean;
    @Items.Action private addItem!: (args: ItemAddArgument) => Promise<Item>

    @Watch('selected.seasons')
    onSeasonsChanged(): void {
        if (this.selected?.seasons) {
            this.selected_seasons = this.selected.seasons.map(item => item.season_number);
        }
    }
    @Watch('search')
    onSearchChange(): void {
        this.doSearch();
    }

    async created(): Promise<void> {
        await this.fetchProfiles(this.type);

        if (this.profiles.length > 0) this.selected_profile = this.profiles[0].id;
    }

    async doSearch(): Promise<void> {
        if (! this.search) return;

        this.loading = true;
        try {
            this.results = await searchItem(this.search, this.type);
        } catch (error) {
            // Nothing
        }
        this.loading = false;
    }
    add(): void {
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
