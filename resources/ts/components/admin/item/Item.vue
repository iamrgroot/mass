<template>
    <v-card
        :style="{
            'background-color': 'grey',
            'cursor': 'pointer',
        }"
        outlined
        @click="goTo(item)"
    >
        <v-img
            eager
            class="blurred-image"
            width="100%"
            max-height="200px"
            :src="item.banner_url"
            gradient="rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)"
            @error="() => { /** Ignore image load error */}"
        >
            <v-list-item three-line>
                <v-list-item-content>
                    <div class="overline mb-2">
                        <v-row
                            no-gutters
                            align="center"
                        >
                            <span class="white--text">{{ item.year }}</span>
                        </v-row>
                    </div>
                    <v-list-item-title class="headline mb-1 white--text">
                        {{ item.title }}
                    </v-list-item-title>
                    <v-list-item-subtitle class="white--text">
                        {{ item.overview }}
                    </v-list-item-subtitle>
                </v-list-item-content>

                <v-list-item-avatar
                    tile
                    height="120"
                    width="80"
                >
                    <v-img
                        :src="item.image_url"
                        :lazy-src="static_image_location"
                        style="border-radius: 5px;"
                        eager
                        contain
                        @error="() => { /** Ignore image load error */}"
                    />
                </v-list-item-avatar>
            </v-list-item>

            <v-card-actions>
                <v-chip
                    v-for="(chip, index) in item.features"
                    :key="`chip_${index}`"
                    class="ma-1"
                    color="white"
                    label
                    small
                    outlined
                >
                    {{ chip.text }}
                </v-chip>
            </v-card-actions>
        </v-img>
    </v-card>
</template>

<style lang="scss" scoped>
    a {
        color: black !important;
    }
</style>

<style lang="scss">
    @import '~@style/item';
</style>

<script lang="ts">
import { defineComponent } from '@vue/composition-api';

import { useItemFeatures } from '@/helpers/item_features';
import { useItems } from '@/store/items';
import { Item } from '@/types/Item';

export default defineComponent({
    props: {
        item: {
            type: Object,
            required: true,
        }
    },
    setup(props, vm) {
        const item_features = useItemFeatures();
        const { item, route_type_is_movie } = useItems();

        const goTo = (item: Item): void => {
            const route = route_type_is_movie ? '/movies/' : '/series/';

            vm.root.$router.push(route + item.id);
        };

        return {
            store_item: item,
            ...item_features,
            goTo,
        };
    }
});
</script>