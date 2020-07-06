<template>
    <v-card
        :loading="loading"
        min-width="100%"
    >
        <v-card-title>
            {{ is_movie ? 'Movies' : 'Series' }}
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
                @click="fetchItems(type)"
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
                    No {{ is_movie ? 'movies' : 'series' }}
                </v-alert>
                <v-row
                    v-else
                    align="center"
                    justify="center"
                >
                    <template>
                        <v-col
                            v-for="item in sorted_items"
                            :key="item.id"
                            :cols="12 / no_columns"
                        >
                            <ItemComponent :item="item" />
                        </v-col>
                    </template>
                </v-row>
            </v-fade-transition>
        </v-card-text>
    </v-card>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { namespace } from 'vuex-class';
import sortBy from 'lodash/sortBy';
import { Item } from '@/types/Item';
import { ItemType } from '@/enums/ItemType';
import ItemComponent from '@/components/item/Item.vue';

const Items = namespace('Items');

@Component({
    components: {
        ItemComponent,
    }
})
export default class List extends Vue {
    @Prop({ required: true }) private type!: number;

    private no_columns = 1;
    private sorted_on = '';
    private descending = false;

    get is_movie(): boolean { return this.type === ItemType.Movie; }
    get sorted_items(): Item[] {
        if (this.sorted_on === '') return this.items;

        return this.descending ?
            sortBy(this.items, this.sorted_on).reverse() :
            sortBy(this.items, this.sorted_on);
    }

    @Items.State public items!: Item[];
    @Items.State public loading!: boolean;
    @Items.Action public fetchItems!: (type: ItemType) => Promise<Item[]>

    created(): void {
        this.fetchItems(this.type);
    }
}
</script>