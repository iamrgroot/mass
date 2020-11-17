<template>
    <div style="min-height: 100vh; min-width: 100vw; background-color: black;">
        <v-img
            v-if="item"
            eager
            contain
            class="blurred-image blurred-image-top"
            width="100%"
            :src="item.image_url"
            gradient="rgba(0,0,0,0.5), rgba(0,0,0,0.5) 60%, black"
            @error="() => { /** Ignore image load error */}"
        >
            <v-row
                class="mt-3"
                align="center"
            >
                <v-btn
                    icon
                    color="white"
                    class="ml-6"
                    @click="$router.go(-1)"
                >
                    <v-icon>$mdiArrowLeft</v-icon>
                </v-btn>
                <v-spacer />
                <template v-if="! $vuetify.breakpoint.mobile">
                    <icon-tooltip
                        v-if="! item_is_movie"
                        text="Seasons"
                        icon="$mdiTelevision"
                        color="white"
                        classes="mr-6"
                        @click="seasons_dialog = true"
                    />
                    <icon-tooltip
                        text="Change quality"
                        icon="$mdiQualityHigh"
                        color="white"
                        classes="mr-6"
                        @click="profile_dialog = true"
                    />
                    <icon-tooltip
                        text="Search automagically"
                        icon="$mdiMagnify"
                        color="white"
                        classes="mr-6"
                        @click="searchIndexersAutomatically(item.id, item.type)"
                    />
                    <icon-tooltip
                        v-if="item_is_movie"
                        text="Search manually"
                        icon="$mdiSearchWeb"
                        color="white"
                        classes="mr-6"
                        @click="searchIndexers(item.id, item.type)"
                    />
                    <icon-tooltip
                        text="Refresh disk and info"
                        icon="$mdiRefresh"
                        color="white"
                        classes="mr-6"
                        @click="refreshItem(item.id, item.type)"
                    />
                    <icon-tooltip
                        text="Delete"
                        icon="$mdiDelete"
                        color="error"
                        classes="mr-12"
                        @click="refreshItem(item.id, item.type)"
                    />
                </template>
                <v-menu
                    v-else
                    bottom
                    close-on-click
                >
                    <template #activator="{ on, attrs }">
                        <v-btn
                            class="mr-12"
                            icon
                            dark
                            v-bind="attrs"
                            v-on="on"
                        >
                            <v-icon>$mdiDotsVertical</v-icon>
                        </v-btn>
                    </template>

                    <v-list>
                        <v-list-item
                            v-if="! item_is_movie"
                            @click="seasons_dialog = true"
                        >
                            Seasons
                        </v-list-item>
                        <v-list-item @click="profile_dialog = true">
                            Change quality
                        </v-list-item>
                        <v-list-item @click="searchIndexersAutomatically(item.id, item.type)">
                            Search automagically
                        </v-list-item>
                        <v-list-item
                            v-if="item_is_movie"
                            @click="searchIndexers(item.id, item.type)"
                        >
                            Search manually
                        </v-list-item>
                        <v-list-item @click="refreshItem(item.id, item.type)">
                            Refresh disk and info
                        </v-list-item>
                        <v-list-item @click="remove">
                            <span class="red--text">Delete</span>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-row>
            <v-row
                justify="center"
                no-gutters
            >
                <v-col cols="4">
                    <v-img
                        :src="item.image_url"
                        class="elevation-5"
                        style="border-radius: 24px;"
                        eager
                        contain
                        @error="() => {}"
                    />
                </v-col>
            </v-row>
            <v-row
                justify="center"
                class="mt-6"
            >
                <v-chip
                    v-for="(chip, index) in item.features"
                    :key="`chip_${index}`"
                    class="ma-1"
                    color="white"
                    label
                    outlined
                    small
                    style="background-color: rgba(60,60,60,0.8)"
                >
                    {{ chip.text }}
                </v-chip>
            </v-row>
            <v-row
                justify="center"
                class="pa-3"
            >
                <v-btn
                    text
                    small
                    class="white--text"
                    @click.stop="openPage(imdbLink(item))"
                >
                    IMDb
                </v-btn>
            </v-row>
            <v-row
                justify="center"
                class="pa-3"
            >
                <v-col
                    cols="12"
                    class="text-h3 white--text font-weight-bold text-center"
                >
                    {{ item.title }}
                </v-col>
            </v-row>
            <v-row
                justify="center"
                class="white--text text-center ma-6"
            >
                <v-col cols="12">
                    {{ item.overview }}
                </v-col>
            </v-row>

            <search-dialog />
            <profile-dialog />
            <seasons-dialog />
        </v-img>
    </div>
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
import { computed, defineComponent, SetupContext } from '@vue/composition-api';
import { Location } from 'vue-router';
import { useItemFeatures } from '@/helpers/item_features';

import { useItems } from '@/store/items';
import { useIndexers } from '@/store/indexers';
import { useProfiles } from '@/store/profiles';

import SearchDialog from '@/components/admin/indexer/SearchDialog.vue';
import ProfileDialog from '@/components/admin/item/ProfileDialog.vue';
import SeasonsDialog from '@/components/admin/item/SeasonsDialog.vue' ;
import IconTooltip from '@/components/defaults/IconTooltip.vue';

const useItemManagement = (vm: SetupContext) => {
    const {
        item,
        item_is_movie,
        item_loading,
        seasons_dialog,
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

    const openPage = (url: string): void => {
        window.open(url, '_blank');
    };


    return {
        item,
        item_is_movie,
        item_loading,
        profile_dialog,
        seasons_dialog,
        remove,
        refreshItem,
        searchIndexers,
        searchIndexersAutomatically,
        openPage,
        ...useItemFeatures(),
    };
};

// TODO fix returns in setup instead of useitemmanage
export default defineComponent({
    components: {
        SearchDialog,
        ProfileDialog,
        SeasonsDialog,
        IconTooltip,
    },
    setup(props, vm) {
        return useItemManagement(vm);
    },
});
</script>