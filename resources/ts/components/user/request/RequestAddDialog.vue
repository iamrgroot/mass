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
                    <v-btn :value="ItemType.Movie">
                        <span class="hidden-sm-and-down">Movie</span>
                        <v-icon right>
                            $mdiMovie
                        </v-icon>
                    </v-btn>
                    <v-btn :value="ItemType.Serie">
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
import { computed, defineComponent, reactive, toRefs, watch } from '@vue/composition-api';
import find from 'lodash/find';

import { SearchResult } from '@/types/Item';

import { ItemType } from '@/enums/ItemType';
import { searchItem } from '@/api/items';
import { putRequest } from '@/api/request';
import { getImageURL } from '@/helpers/images';
import { useRequests } from '@/store/requests';

export default defineComponent({
    props: {
        value: {
            type: Boolean,
            required: true,
        }
    },
    setup(props, vm) {
        const store = reactive({
            type: ItemType.Movie,
            searching: false,
            search: '',
            results: [] as SearchResult[],
            selected: null as SearchResult | null,
        });

        const { requests } = useRequests();

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

        const put = async (): Promise<void> => {
            if (store.selected) {
                requests.value.push(await putRequest(store.selected));
                vm.emit('input', false);
            }
        };

        const changeType = (): void => {
            store.search = '';
            store.selected = null;
            store.results = [];
        };

        watch(() => store.search, (): void => {
            doSearch();
        });

        return {
            ...toRefs(store),
            ItemType,
            requests,
            image_url,
            doSearch,
            put,
            changeType,
        };
    },
});
</script>