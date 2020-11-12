<template>
    <v-card
        :loading="item_loading"
        class="ma-3"
    >
        <template v-if="! item_loading">
            <v-card-title>
                {{ item.title }}
                <v-spacer />
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            class="ma-1"
                            v-bind="attrs"
                            v-on="on"
                            @click="profile_dialog = true"
                        >
                            <v-icon>$mdiQualityHigh</v-icon>
                        </v-btn>
                    </template>
                    <span>Change quality</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            class="ma-1"
                            v-bind="attrs"
                            v-on="on"
                            @click="searchIndexersAutomatically(item.id, item.type)"
                        >
                            <v-icon>$mdiMagnify</v-icon>
                        </v-btn>
                    </template>
                    <span>Search automagically</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            v-if="item_is_movie"
                            icon
                            class="ma-1"
                            v-bind="attrs"
                            v-on="on"
                            @click="searchIndexers(item.id, item.type)"
                        >
                            <v-icon>$mdiSearchWeb</v-icon>
                        </v-btn>
                    </template>
                    <span>Search manually</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            class="ma-1"
                            v-bind="attrs"
                            v-on="on"
                            @click="refreshItem(item.id, item.type)"
                        >
                            <v-icon>$mdiRefresh</v-icon>
                        </v-btn>
                    </template>
                    <span>Refresh disk and info</span>
                </v-tooltip>
                <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            icon
                            class="ma-1"
                            color="error"
                            v-bind="attrs"
                            v-on="on"
                            @click="remove"
                        >
                            <v-icon>$mdiDelete</v-icon>
                        </v-btn>
                    </template>
                    <span>Delete</span>
                </v-tooltip>
            </v-card-title>
            <v-divider class="mx-3" />
            <v-card-text>
                <v-row class="ml-1">
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
                    <v-spacer />
                    <seasons-button v-if="! item_is_movie" />
                    <v-btn
                        text
                        small
                        target="_blank"
                        :href="imdbLink(item)"
                        class="mx-1"
                    >
                        IMDb
                    </v-btn>
                </v-row>
                <v-row>
                    <v-col cols="10">
                        <v-row>
                            <v-col>
                                {{ item.overview }}
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="2">
                        <v-img
                            :src="imageLink(item)"
                            :lazy-src="static_image_location"
                            eager
                            contain
                            @error="() => {}"
                        />
                    </v-col>
                </v-row>
            </v-card-text>
        </template>

        <search-dialog />
        <profile-dialog />
    </v-card>
</template>

<style lang="scss" scoped>
    a {
        color: black !important;
    }
</style>

<script lang="ts">
import { computed, defineComponent, SetupContext } from '@vue/composition-api';
import { Location } from 'vue-router';
import { useItemFeatures } from '@/helpers/item_features';

import { useItems } from '@/store/items';
import { useIndexers } from '@/store/indexers';
import { useProfiles } from '@/store/profiles';

import SearchDialog from '@/components/admin/indexer/SearchDialog.vue';
import ProfileDialog from '@/components/admin/item/ProfileDialog.vue';
import SeasonsButton from '@/components/admin/item/SeasonsButton.vue' ;

const useItemManagement = (vm: SetupContext) => {
    const {
        route_type,
        item,
        item_is_movie,
        item_loading,
        fetchItem,
        deleteItem,
        refreshItem,
    } = useItems();
    const {
        searchIndexers,
        searchIndexersAutomatically,
    } = useIndexers();
    const { profile_dialog } = useProfiles();

    const redirect = computed((): Location => {
        return { name: item_is_movie.value ? 'movies' : 'series'};
    });

    const fetch = (): void => {
        fetchItem(
            Number(vm.root.$route.params.id),
            route_type.value
        ).catch(() => {

            vm.root.$router.push(redirect.value);
        });
    };

    const remove = (): void => {
        const text = item_is_movie.value ? 'movie' : 'serie';

        vm.root.$confirm(`Delete ${text}?`).then(confirmed => {
            if (! confirmed || ! item.value) {
                return;
            }

            deleteItem(item.value.id, item.value.type)
                .then(() => {
                    vm.root.$router.push(redirect.value);
                });
        });
    };
    return {
        item,
        item_is_movie,
        item_loading,
        fetch,
        remove,
        refreshItem,
        profile_dialog,
        searchIndexers,
        searchIndexersAutomatically,
        ...useItemFeatures(),
    };
};

// TODO fix returns in setup instead of useitemmanage
export default defineComponent({
    components: {
        SearchDialog,
        ProfileDialog,
        SeasonsButton,
    },
    setup(props, vm) {
        return useItemManagement(vm);
    },
    created() {
        this.fetch();
    }
});
</script>