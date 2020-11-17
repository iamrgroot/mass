<template>
    <v-card
        :loading="items_loading"
        min-width="100%"
    >
        <v-card-title>
            <span class="ml-6">{{ route_type_is_movie ? 'Movies' : 'Series' }}</span>
            <v-spacer />
            <!-- <v-select
                v-model="no_columns"
                label="# columns"
                :items="[1, 2, 3, 4]"
                class="mx-4"
                :style="{
                    'max-width': '100px'
                }"
            />

            <v-select
                v-model="sorted_on"
                :items="[{
                    'value': '',
                    'text': ''
                },{
                    'value': 'title',
                    'text': 'Title'
                },{
                    'value': 'year',
                    'text': 'Year'
                }]"
                label="Sorting"
                class="mx-4"
                :style="{
                    'max-width': '100px'
                }"
            />
            <v-btn
                icon
                @click="descending = ! descending"
            >
                <v-icon>
                    {{ descending ? '$mdiSortDescending' : '$mdiSortAscending' }}
                </v-icon>
            </v-btn> -->
            <v-btn
                icon
                @click="fetchItems()"
            >
                <v-icon>$mdiRefresh</v-icon>
            </v-btn>
        </v-card-title>
        <v-card-text>
            <v-fade-transition mode="out-in">
                <div
                    v-if="items_loading"
                />
                <v-alert
                    v-else-if="items.length === 0"
                    text
                    dense
                    min-width="99%"
                    color="warning"
                    icon="$mdiCloudAlert"
                    class="text-center"
                >
                    No {{ route_type_is_movie ? 'movies' : 'series' }}
                </v-alert>
                <v-row
                    v-else
                    align="center"
                    justify="center"
                >
                    <v-col
                        v-for="item in sorted_items"
                        :key="item.id"
                        :cols="12 / no_columns"
                    >
                        <item-component :item="item" />
                    </v-col>
                </v-row>
            </v-fade-transition>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
import { computed, defineComponent, reactive, toRefs } from '@vue/composition-api';

import ItemComponent from '@/components/admin/item/Item.vue';

import { useItems } from '@/store/items';
import sortBy from 'lodash/sortBy';
import { Item } from '@/types/Item';

const useItemList = () => {
    const {
        movies,
        series,
        movies_loading,
        series_loading,
        fetchMovies,
        fetchSeries,
        route_type_is_movie,
    } = useItems();

    const item_list_data = reactive({
        no_columns: 1,
        sorted_on: '',
        descending: false,
    });

    const items = computed(() => route_type_is_movie.value ? movies.value : series.value );
    const items_loading = computed(() => route_type_is_movie.value ? movies_loading.value : series_loading.value );

    const fetchItems = (): void => {
        if (route_type_is_movie.value) {
            fetchMovies();
        } else {
            fetchSeries();
        }
    };

    const sorted_items = computed((): Item[] => {
        if (item_list_data.sorted_on === '') return items.value;

        return item_list_data.descending ?
            sortBy(items.value, item_list_data.sorted_on).reverse() :
            sortBy(items.value, item_list_data.sorted_on);
    });

    return {
        ...toRefs(item_list_data),
        items,
        items_loading,
        sorted_items,
        fetchItems,
    };
};

export default defineComponent({
    components: {
        ItemComponent,
    },
    setup() {
        const {
            item,
            route_type_is_movie,
        } = useItems();

        return {
            ...useItemList(),
            item,
            route_type_is_movie,
        };
    },
});
</script>