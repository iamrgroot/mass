<template>
    <v-card
        :loading="items_loading"
        min-width="100%"
    >
        <v-card-title>
            {{ route_type_is_movie ? 'Movies' : 'Series' }}
            <v-spacer />
            <v-select
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
            </v-btn>
            <v-btn
                icon
                @click="fetchItems()"
            >
                <v-icon>$mdiRefresh</v-icon>
            </v-btn>
        </v-card-title>
        <v-divider />
        <v-card-text>
            <v-fade-transition mode="out-in">
                <v-alert
                    v-if="items.length === 0"
                    text
                    dense
                    min-width="99%"
                    color="warning"
                    icon="$mdiCloudAlert"
                    class="text-center"
                >
                    No {{ route_type_is_movie ? 'movies' : 'series' }}
                </v-alert>
                <v-progress-linear
                    v-else-if="items_loading"
                    indeterminate
                />
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

        <v-dialog
            :value="item !== null"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
        >
            <item-page />
        </v-dialog>
    </v-card>
</template>

<script lang="ts">
import { computed, defineComponent, reactive, toRefs } from '@vue/composition-api';

import ItemComponent from '@/components/admin/item/Item.vue';
import ItemPage from '@/components/admin/item/ItemPage.vue';

import { useItems } from '@/store/items';
import sortBy from 'lodash/sortBy';
import { Item } from '@/types/Item';

const useItemList = () => {
    const { items } = useItems();

    const item_list_data = reactive({
        no_columns: 1,
        sorted_on: '',
        descending: false,
    });

    const sorted_items = computed((): Item[] => {
        if (item_list_data.sorted_on === '') return items.value;

        return item_list_data.descending ?
            sortBy(items.value, item_list_data.sorted_on).reverse() :
            sortBy(items.value, item_list_data.sorted_on);
    });

    return {
        ...toRefs(item_list_data),
        sorted_items,
    };
};

export default defineComponent({
    components: {
        ItemComponent,
        ItemPage,
    },
    setup() {
        const {
            items,
            item,
            items_loading,
            fetchItems,
            route_type_is_movie,
        } = useItems();

        return {
            ...useItemList(),
            items,
            item,
            items_loading,
            route_type_is_movie,
            fetchItems,
        };
    },
    created() {
        this.fetchItems();
    }
});
</script>