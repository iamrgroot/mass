<template>
    <v-dialog
        :value="value"
        width="800px"
        @input="dialog => $emit('input', dialog)"
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
                    @change="clear()"
                >
                    <v-btn :value="ItemType.Movie">
                        <span>Movie</span>
                        <v-icon right>
                            $mdiMovie
                        </v-icon>
                    </v-btn>
                    <v-btn :value="ItemType.Serie">
                        <span>Series</span>
                        <v-icon right>
                            $mdiTelevision
                        </v-icon>
                    </v-btn>
                </v-btn-toggle>
            </v-card-title>
            <v-card-text>
                <v-row no-gutters>
                    <v-col
                        cols="12"
                        md="8"
                    >
                        <v-row no-gutters>
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
                        </v-row>
                        <template v-if="! request && selected">
                            <v-row no-gutters>
                                <v-select
                                    v-model="selected_profile"
                                    :items="relevant_profiles"
                                    item-text="name"
                                    item-value="id"
                                    label="Profile"
                                    class="px-2"
                                />
                            </v-row>
                            <v-row
                                v-if="! request && selected && type === ItemType.Serie"
                                no-gutters
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
                            </v-row>
                        </template>
                    </v-col>
                    <v-col
                        cols="12"
                        md="4"
                        align-self="center"
                    >
                        <v-row
                            no-gutters
                            align="center"
                        >
                            <v-img
                                :src="image_url"
                                max-height="200"
                                max-width="100%"
                                contain
                            />
                        </v-row>
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
import { computed, defineComponent, reactive, toRefs, watch } from '@vue/composition-api';
import find from 'lodash/find';

import { Profile, SearchResult } from '@/types/Item';

import { ItemType } from '@/enums/ItemType';
import { searchItem } from '@/api/items';
import { putRequest } from '@/api/request';
import { getImageURL } from '@/helpers/images';
import { useRequests } from '@/store/requests';
import { useItems } from '@/store/items';
import { useProfiles } from '@/store/profiles';

export default defineComponent({
    props: {
        value: {
            type: Boolean,
            required: true,
        },
        request: {
            type: Boolean,
            default: false,
        }
    },
    setup(props, vm) {
        const store = reactive({
            type: ItemType.Movie,
            searching: false,
            search: '',
            results: [] as SearchResult[],
            selected: null as SearchResult | null,
            selected_profile: null as number | null,
            selected_seasons: [] as number[],
        });

        const { requests } = useRequests();
        const { addItem } = useItems();
        const { movie_profiles, serie_profiles } = useProfiles();

        const relevant_profiles = computed((): Profile[] => {
            return store.type === ItemType.Movie ? movie_profiles.value : serie_profiles.value;
        });

        const image_url = computed((): string => {
            const shiba = '/images/shiba_poster.jpg';

            if (! store.selected) {
                return shiba;
            }

            const image = store.selected.images.find(image => image.coverType === 'poster');

            if (! image) {
                return shiba;
            }

            return getImageURL(store.type, image.url);
        });

        const doSearch = async (): Promise<void> => {
            if (! store.search) return;

            store.searching = true;
            try {
                const results = await searchItem(store.search, store.type);

                const search = store.type === ItemType.Movie ? 'tmdb_id' : 'tvdb_id';

                store.results = results.filter(result => ! find(requests.value, {type: store.type, item_id: result[search]}));
            } catch (error) {
                // Nothing
            }
            store.searching = false;
        };

        const clear = (): void => {
            store.search = '';
            store.selected = null;
            store.results = [];
            store.selected_profile = null;
            store.selected_seasons = [];
        };

        const put = async (): Promise<void> => {
            if (! store.selected) {
                return;
            }

            if (props.request) {
                requests.value.push(await putRequest(store.selected));
                vm.emit('input', false);
            } else {
                if (store.selected_profile) {
                    await addItem(
                        store.type,
                        store.selected,
                        store.selected_profile,
                        store.selected_seasons
                    );
                }
            }

            vm.emit('input', false);
            clear();
        };


        watch(() => store.search, (): void => {
            doSearch();
        });

        return {
            ...toRefs(store),
            requests,
            image_url,
            relevant_profiles,
            ItemType,
            put,
            doSearch,
            clear,
        };
    },
});
</script>