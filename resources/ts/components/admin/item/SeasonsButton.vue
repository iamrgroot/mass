<template>
    <div>
        <v-btn
            text
            small
            class="mx-1"
            @click="seasons_dialog = true"
        >
            Seasons
        </v-btn>

        <v-dialog
            v-model="seasons_dialog"
            max-width="600"
        >
            <v-card>
                <v-toolbar
                    dense
                    flat
                >
                    <v-toolbar-title>
                        Seasons
                    </v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-expansion-panels accordion>
                        <v-expansion-panel
                            v-for="(season, index) in item.seasons"
                            :key="index"
                        >
                            <v-expansion-panel-header>
                                <v-row
                                    no-gutters
                                    align="center"
                                >
                                    <v-checkbox
                                        :input-value="season.monitored"
                                        class="ma-0 pa-0"
                                        hide-details
                                        @change="toggleSeason(item.id, season.season_number, ! season.monitored)"
                                        @click.native.stop
                                    />
                                    <span>
                                        Season {{ season.season_number }}
                                    </span>
                                </v-row>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                                <v-list dense>
                                    <v-list-item
                                        v-for="(episode, episode_index) in season.episodes"
                                        :key="episode_index"
                                        class="ma-0"
                                    >
                                        <v-list-item-content class="pa-0">
                                            <v-list-item-title>
                                                <v-row
                                                    no-gutters
                                                    align="center"
                                                    justify="space-between"
                                                >
                                                    <span>Episode {{ episode.episode_number }}</span>
                                                    <v-tooltip bottom>
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-btn
                                                                icon
                                                                class="ma-1"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                                @click="searchIndexers(episode.id, item.type)"
                                                            >
                                                                <v-icon>$mdiSearchWeb</v-icon>
                                                            </v-btn>
                                                        </template>
                                                        <span>Search episode {{ episode.episode_number }} manually</span>
                                                    </v-tooltip>
                                                </v-row>
                                            </v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list>
                            </v-expansion-panel-content>
                        </v-expansion-panel>
                    </v-expansion-panels>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from '@vue/composition-api';
import { useItems } from '@/store/items';
import { useIndexers } from '@/store/indexers';

export default defineComponent({
    setup() {
        const seasons_dialog = ref(false);
        const { item, toggleSeason } = useItems();
        const { searchIndexers } = useIndexers();

        return {
            seasons_dialog,
            item,
            toggleSeason,
            searchIndexers,
        };
    }
});
</script>