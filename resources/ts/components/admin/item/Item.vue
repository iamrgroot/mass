<template>
    <v-card outlined>
        <v-list-item three-line>
            <v-list-item-content>
                <div class="overline mb-2">
                    <v-row
                        no-gutters
                        align="center"
                    >
                        <span>{{ item.year }}</span>
                        <v-spacer />
                        <v-btn
                            text
                            small
                            target="_blank"
                            :href="imdbLink(item)"
                        >
                            IMDb
                        </v-btn>
                    </v-row>
                </div>
                <v-list-item-title class="headline mb-1">
                    <a @click="goTo">
                        {{ item.title }}
                    </a>
                </v-list-item-title>
                <v-list-item-subtitle>{{ item.overview }}</v-list-item-subtitle>
            </v-list-item-content>

            <v-list-item-avatar
                tile
                height="120"
                width="80"
            >
                <v-img
                    :src="imageLink(item)"
                    :lazy-src="static_image_location"
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
                :color="chip.color"
                label
                small
            >
                {{ chip.text }}
            </v-chip>
        </v-card-actions>
    </v-card>
</template>

<style lang="scss" scoped>
    a {
        color: black !important;
    }
</style>


<script lang="ts">
import { defineComponent } from '@vue/composition-api';
import { useItems } from '@/store/items';
import { useItemFeatures } from '@/helpers/item_features';

export default defineComponent({
    setup(props, vm) {
        const { item, item_is_movie } = useItems();
        const item_features = useItemFeatures();

        const goTo = (): void => {
            const route = item_is_movie ? 'movie' : 'serie';

            vm.root.$router.push({ name: route, params: { id: String(item.value!.id) }});
        };

        return {
            goTo,
            item,
            ...item_features,
        };
    }
});
</script>