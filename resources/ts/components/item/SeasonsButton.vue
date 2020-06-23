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
                    <v-list dense>
                        <v-checkbox
                            v-for="season in item.seasons"
                            :key="`season_${season.season_number}`"
                            :label="`Season ${season.season_number}`"
                            :input-value="season.monitored"
                            hide-details
                            @change="toggleMonitor(season.season_number, ! season.monitored)"
                        />
                    </v-list>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { namespace } from 'vuex-class';
import { Item } from '@/types/Item';
import { SerieUpdateArgument } from '@/types/Args';

const Items = namespace('Items');

@Component
export default class SeasonsButtom extends Vue {
    private dialog = false;

    @Items.State item!: Item;

    @Items.Action private toggleSeason!: (args: SerieUpdateArgument) => Promise<Item>;

    toggleMonitor(season: number, motitor: boolean) {
        this.toggleSeason({
            item_id: this.item.id,
            season: season,
            monitor: motitor
        });
    }
}
</script>