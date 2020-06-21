<template>
    <v-card
        class="ma-3"
    >
        <v-card-title>
            <span>Torrents</span>
            <v-spacer />
            <v-btn
                icon
                class="ma-2"
                @click="fetchTorrents"
            >
                <v-icon>
                    mdi-refresh
                </v-icon>
            </v-btn>
        </v-card-title>
        <v-divider class="mx-3" />
        <v-card-text>
            <v-data-table
                :headers="headers"
                :items="torrents"
                :items-per-page="15"
            >
                <template v-slot:body="{ items }">
                    <tbody>
                        <template v-for="item in items">
                            <tr
                                :key="`1_${item.id}`"
                                class="no-border"
                            >
                                <td>
                                    {{ item.status }}
                                </td>
                                <td>
                                    {{ item.name }}
                                </td>
                                <td>
                                    {{ item.eta > 0 ? $d(item.eta, 'time') : '∞' }}
                                </td>
                                <td>
                                    {{ item.rate_download | bytesPerSecond }}
                                </td>
                                <td>
                                    {{ item.rate_download | bytesPerSecond }}
                                </td>
                                <td>
                                    {{ item.size_when_done | byte }}
                                </td>
                                <td>
                                    {{ item.error_string }}
                                </td>
                            </tr>
                            <tr 
                                :key="`2_${item.id}`"
                                class="progress-row pb-3"
                            >
                                <td :colspan="headers.length">
                                    <v-progress-linear :value="item.percent_done * 100"></v-progress-linear>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>

<style lang="scss" scoped>
    .progress-row > td {
        height: 15px !important;
    }

    .no-border > td {
        border-bottom: none !important;
    }
</style>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { namespace } from 'vuex-class';
import { Torrent } from '@/types/Torrent';
import { byte, bytesPerSecond } from "@/filters/filters";

const Torrents = namespace('Torrents');

@Component({
    filters: {
        byte: byte,
        bytesPerSecond: bytesPerSecond
    }
})
export default class TorrentsPage extends Vue {
    private headers = [
        { text: 'Status', value: 'status' },
        // { text: 'Progress', value: 'percent_done' },
        { text: 'Name', value: 'name' },
        { text: 'ETA', value: 'eta' },
        { text: 'Download', value: 'rate_download' },
        { text: 'Upload', value: 'rate_download' },
        { text: 'Size', value: 'size_when_done' },
        { text: 'Error', value: 'error_string' },
    ];

    @Torrents.State private torrents!: Array<Torrent>;
    @Torrents.Action private fetchTorrents!: () => Promise<Array<Torrent>>;

    created() {
        this.fetchTorrents();
    }
}
</script>