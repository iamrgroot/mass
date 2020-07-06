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
                <v-icon>$mdiRefresh</v-icon>
            </v-btn>
        </v-card-title>
        <v-divider class="mx-3" />
        <v-card-text>
            <v-fade-transition mode="out-in">
                <v-alert
                    v-if="torrents.length === 0"
                    text
                    dense
                    color="warning"
                    icon="$mdiCloudAlert"
                    class="text-center"
                >
                    No torrents
                </v-alert>
                <v-data-table
                    v-else
                    :headers="headers"
                    :items="torrents"
                    :items-per-page="15"
                >
                    <template v-slot:body="{ items }">
                        <tbody>
                            <template v-for="item in items">
                                <tr
                                    :key="`1_${item.id}`"
                                    :class="{
                                        'error--text': hasError(item)
                                    }"
                                    class="no-border"
                                >
                                    <td>
                                        <v-icon
                                            v-if="! paused(item)"
                                            :color="color(item)"
                                            @click="stopTorrent(item)"
                                        >
                                            $mdiPause
                                        </v-icon>
                                        <v-icon
                                            v-else
                                            :color="color(item)"
                                            @click="startTorrent(item)"
                                        >
                                            $mdiPlay
                                        </v-icon>
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
                                    <td>
                                        <v-icon
                                            color="error"
                                            @click="remove(item)"
                                        >
                                            $mdiDelete
                                        </v-icon>
                                    </td>
                                </tr>
                                <tr
                                    :key="`2_${item.id}`"
                                    class="progress-row pb-3"
                                >
                                    <td :colspan="headers.length">
                                        <v-progress-linear
                                            :value="item.percent_done * 100"
                                            :color="color(item)"
                                            :buffer-value="stream(item) ? 0 : 100"
                                            :stream="stream(item)"
                                        />
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </template>
                </v-data-table>
            </v-fade-transition>
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
import { byte, bytesPerSecond } from '@/filters/filters';
import { TorrentStatus } from '@/enums/TorrentStatus';

const Torrents = namespace('Torrents');

@Component({
    filters: {
        byte: byte,
        bytesPerSecond: bytesPerSecond
    }
})
export default class TorrentsPage extends Vue {
    private headers = [
        { text: '', value: 'play_pause', sortable: false },
        { text: 'Name', value: 'name' },
        { text: 'ETA', value: 'eta' },
        { text: 'Download', value: 'rate_download' },
        { text: 'Upload', value: 'rate_download' },
        { text: 'Size', value: 'size_when_done' },
        { text: 'Error', value: 'error_string' },
        { text: '', value: 'delete', sortable: false },
    ];
    private torrent_fetcher!: number;

    @Torrents.State private torrents!: Torrent[];
    @Torrents.Action private fetchTorrents!: () => Promise<Torrent[]>;
    @Torrents.Action private removeTorrent!: (torrent: Torrent) => Promise<boolean>;
    @Torrents.Action private stopTorrent!: (torrent: Torrent) => Promise<boolean>;
    @Torrents.Action private startTorrent!: (torrent: Torrent) => Promise<boolean>;

    paused(torrent: Torrent): boolean { return torrent.status === TorrentStatus.Paused; }
    hasError(torrent: Torrent): boolean { return torrent.error_string !== null; }
    stream(torrent: Torrent): boolean { return ! this.hasError(torrent) && ! this.paused(torrent); }
    color(torrent: Torrent): string { return this.hasError(torrent) ? 'error' : (this.paused(torrent) ? 'grey' : 'success'); }

    created(): void {
        this.fetchTorrents();
        this.torrent_fetcher = setInterval(
            this.fetchTorrents,
            2500
        );
    }
    beforeDestroy(): void {
        clearInterval(this.torrent_fetcher);
    }

    async remove(item: Torrent): Promise<void> {
        if (await this.$root.$confirm('Delete torrent?')) {
            this.removeTorrent(item);
        }
    }
}
</script>