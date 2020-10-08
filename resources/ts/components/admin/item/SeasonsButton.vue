<template>
    <div>
        <v-btn
            text
            small
            class="mx-1"
            @click="dialog = true"
        >
            Seasons
        </v-btn>

        <v-dialog
            v-model="dialog"
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
                                        @change="toggleMonitor(season.season_number, ! season.monitored)"
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
                                                                @click="manualSearch({
                                                                    item_id: episode.id,
                                                                    type: item.type
                                                                })"
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
import { Component, Vue } from 'vue-property-decorator';
import { namespace } from 'vuex-class';
import { Item, IndexResult } from '@/types/Item';
import { SerieUpdateArgument, ItemTypeArgument } from '@/types/Args';

const Items = namespace('Items');
const Indexers = namespace('Indexers');

@Component
export default class SeasonsButtom extends Vue {
    private dialog = false;

    @Items.State item!: Item;

    @Items.Action private toggleSeason!: (args: SerieUpdateArgument) => Promise<Item>;

    @Indexers.Action private manualSearch!: (args: ItemTypeArgument) => Promise<IndexResult[]>;

    toggleMonitor(season: number, motitor: boolean): Promise<Item> {
        return this.toggleSeason({
            item_id: this.item.id,
            season: season,
            monitor: motitor
        });
    }
}
</script>