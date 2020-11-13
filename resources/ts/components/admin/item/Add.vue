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
                        :items="search_results"
                        :loading="search_loading"
                        :search-input.sync="search"
                        item-text="text"
                        item-value="tmdb_id"
                        label="Add Item"
                        placeholder="Start typing"
                        prepend-icon="$mdiDatabaseSearch"
                        return-object
                        cache-items
                        :error-messages="item_add_errors"
                        class="pr-2"
                    />
                </v-col>
                <v-col cols="2">
                    <v-select
                        v-model="selected_profile"
                        :items="relevant_profiles"
                        item-text="name"
                        item-value="id"
                        label="Profile"
                        class="px-2"
                    />
                </v-col>
                <v-col
                    v-if="! route_type_is_movie && selected !== null"
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
import { defineComponent, reactive, toRefs, watch } from '@vue/composition-api';

import { searchItem } from '@/api/items';

import { useItems } from '@/store/items';
import { useProfiles } from '@/store/profiles';

import { SearchResult } from '@/types/Item';

const useSearch = () => {
    const search_data = reactive({
        search_results: [] as SearchResult[],
        search: '',
        selected: null as SearchResult | null,
        selected_profile: null as number | null,
        selected_seasons: [] as number[],
        search_loading: false,
    });

    const { relevant_profiles } = useProfiles();
    const { route_type, route_type_is_movie, item_add_errors, addItem } = useItems();

    watch(relevant_profiles, () => {
        if (relevant_profiles.value.length > 0) search_data.selected_profile = relevant_profiles.value[0].id;
    });

    watch(() => search_data.selected?.seasons, () => {
        if (search_data.selected?.seasons) {
            search_data.selected_seasons = search_data.selected.seasons.map(item => item.season_number);
        }
    });

    watch(() => search_data.search, async () => {
        if (! search_data.search) return;

        search_data.search_loading = true;
        try {            
            search_data.search_results = await searchItem(search_data.search, route_type.value);
        } catch (error) {
            // Nothing
        }
        search_data.search_loading = false;
    });

    const add = (): void => {
        if (! search_data.selected || ! search_data.selected_profile) return;

        addItem(
            search_data.selected,
            search_data.selected_profile,
            search_data.selected_seasons
        );
    };

    return {
        ...toRefs(search_data),
        add,
        item_add_errors,
        route_type_is_movie,
        relevant_profiles,
    };
};

export default defineComponent({
    setup() {
        return {
            ...useSearch(),
        };
    },
});
</script>
