<template>
    <div>
        <div
            v-if="$vuetify.breakpoint.mobile"
            style="background-color: black; min-height: 100vh;"
        >
            <div
                v-if="item"
                :style="{
                    backgroundImage: `url(${item.image_url}`,
                    backgroundSize: 'contain',
                    filter: 'blur(60px)',
                    width: '100vw',
                    height: '100vh',
                    transform: 'scale(150%)',
                    backgroundBlendMode: 'overlay',
                    backgroundPosition: 'center top',
                    backgroundRepeat: 'no-repeat',
                    position: 'relative',
                    zIndex: 0
                }"
            />
            <div
                v-if="item"
                :style="{
                    marginTop: '-100vh',
                    position: 'relative'
                }"
            >
                <v-row
                    class="mt-3"
                    align="center"
                >
                    <v-btn
                        icon
                        color="white"
                        class="ml-6"
                        @click="item = null"
                    >
                        <v-icon>$mdiArrowLeft</v-icon>
                    </v-btn>
                    <v-spacer />
                    <v-btn
                        text
                        small
                        class="white--text mr-3"
                        @click.stop="openPage(imdbLink(item))"
                    >
                        IMDb
                    </v-btn>

                    <v-menu
                        bottom
                        close-on-click
                    >
                        <template #activator="{ on, attrs }">
                            <v-btn
                                class="mr-6"
                                icon
                                dark
                                v-bind="attrs"
                                v-on="on"
                            >
                                <v-icon>$mdiDotsVertical</v-icon>
                            </v-btn>
                        </template>

                        <v-list>
                            <!-- <v-list-item v-if="! item_is_movie" @click="seasons_dialog = true">
                            Seasons
                        </v-list-item> -->
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
                    :style="{
                        padding: '0 5vw'
                    }"
                >
                    <h1 class="text-h3 white--text font-weight-bold text-center mt-6">
                        {{ item.title }}
                    </h1>
                    <p class="white--text text-center mt-6">
                        {{ item.overview }}
                    </p>
                </v-row>
            </div>
        </div>
        <v-card
            v-else
            :loading="item_loading"
            class="ma-3"
        >
            <template v-if="item">
                <v-card-title>
                    {{ item.title }}
                    <v-spacer />
                    <v-tooltip bottom>
                        <template #activator="{ on, attrs }">
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
                        <template #activator="{ on, attrs }">
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
                        <template #activator="{ on, attrs }">
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
                        <template #activator="{ on, attrs }">
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
                        <template #activator="{ on, attrs }">
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
                                :src="item.image_url"
                                :lazy-src="static_image_location"
                                eager
                                contain
                                @error="() => {}"
                            />
                        </v-col>
                    </v-row>
                </v-card-text>
            </template>
        </v-card>

        <search-dialog />
        <profile-dialog />
    </div>
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
        item,
        item_is_movie,
        item_loading,
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
        remove,
        refreshItem,
        profile_dialog,
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
        SeasonsButton,
    },
    setup(props, vm) {
        return useItemManagement(vm);
    },
});
</script>