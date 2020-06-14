<template>
    <v-card
        :loading="loading"
        min-width="100%"
    >
        <v-card-title>
            {{ is_movie ? 'Movies' : 'Series' }}
            <v-spacer/>
            <v-select
                v-model="layout"
                :items="[{
                    text: 'Grid',
                    value: 'grid'
                }, {
                    text: 'Card',
                    value: 'card'
                }]"
                class="mx-4"
                :style="{
                    'max-width': '100px'
                }"
            ></v-select>

            <v-select
                v-if="this.layout === 'grid'"
                v-model="no_columns"
                label="# columns"
                :items="[{
                    text: 1,
                    value: 1
                }, {
                    text: 2,
                    value: 2
                }, {
                    text: 3,
                    value: 3
                }, {
                    text: 4,
                    value: 4
                }]"
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
            ></v-select>
            <v-btn
                icon
                @click="descending = ! descending"
            >
                <v-icon>
                    {{ descending ? 'mdi-sort-descending' : 'mdi-sort-ascending'}}
                </v-icon>
            </v-btn>
            <v-btn
                icon
                @click="fetch(type); refresh++;"
            >
                <v-icon>
                    mdi-refresh
                </v-icon>
            </v-btn>
        </v-card-title>
        <v-divider/>
        <v-card-text :key="refresh">
            <v-row 
                align="center"
                justify="center"
            >
                <template v-if="layout === 'card'">
                    <!-- <Item 
                        v-for="item in sorted_items"
                        :key="item.id"
                        :item="item"
                        :layout="layout"
                        class="ma-3"
                    /> -->
                </template>
                
                <v-col 
                    v-else
                    v-for="item in sorted_items"
                    :key="item.id"
                    :cols="12 / no_columns"
                >
                    <!-- <Item 
                        :item="item"
                        :layout="layout"
                    /> -->
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>


<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { namespace } from 'vuex-class';
import { sortBy } from 'lodash';
import { Item } from '@/types/item';
import { ItemType } from '@/enums/ItemType';

const Items = namespace('Items');

@Component
export default class List extends Vue {
    @Prop({ required: true }) private type!: number;

    private layout = 'grid';
    private no_columns = 1;
    private sorted_on = '';
    private descending = false;
    private refresh = 0;

    get is_movie(): boolean { return this.type === ItemType.Movie; }
    get cookie_name(): string { return this.is_movie ? 'movie_settings' : 'serie_settings'}
    get sorted_items(): Array<Item> {
        if(this.sorted_on === '') return this.items;

        return this.descending ?
            sortBy(this.items, this.sorted_on).reverse() :
            sortBy(this.items, this.sorted_on);
    }

    @Items.State public items!: Array<Item>;
    @Items.State public loading!: boolean;

    // @Watch('layout')
    // onLayoutChanged() { this.setCookie(); }
}
</script>