import { reactive, toRefs } from '@vue/composition-api';

import axios from '@/plugins/axios';

import { Torrent } from '@/types/Torrent';

export const useTorrents = () => {
    const torrent_store = reactive({
        torrents: [] as Torrent[],
        torrents_loading: false,
    });

    const fetchTorrents = (): Promise<Torrent[]> => {
        return new Promise((resolve, reject) => {
            torrent_store.torrents_loading = true;

            axios.get('/async/torrents').then(({ data }) => {
                torrent_store.torrents = data;
                resolve(data);
            }).catch(error => {
                reject(error);
            }).finally(() => {
                torrent_store.torrents_loading = false;
            });
        });
    };

    const removeTorrent = (torrent: Torrent): Promise<Torrent[]> => {
        return new Promise((resolve, reject) => {
            axios.delete(`/async/torrents/${torrent.id}/delete`).then(({ data }) => {
                torrent_store.torrents = data;
                resolve(data);
            }).catch(error => {
                reject(error);
            });
        });
    };

    const stopTorrent = (torrent: Torrent): Promise<Torrent[]> => {
        return new Promise((resolve, reject) => {
            axios.post(`/async/torrents/${torrent.id}/stop`).then(({ data }) => {
                torrent_store.torrents = data;
                resolve(data);
            }).catch(error => {
                reject(error);
            });
        });
    };
    const startTorrent = (torrent: Torrent): Promise<Torrent[]> => {
        return new Promise((resolve, reject) => {
            axios.post(`/async/torrents/${torrent.id}/start`).then(({ data }) => {
                torrent_store.torrents = data;
                resolve(data);
            }).catch(error => {
                reject(error);
            });
        });
    };

    return {
        ...toRefs(torrent_store),
        fetchTorrents,
        removeTorrent,
        stopTorrent,
        startTorrent,
    };
};