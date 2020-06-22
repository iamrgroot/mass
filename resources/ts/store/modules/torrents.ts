import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators';
import axios from '@/plugins/axios';
import { Torrent } from '@/types/Torrent';

@Module({ namespaced: true })
class Torrents extends VuexModule {
    public torrents: Array<Torrent> = [];
    public loading = false;

    @Mutation
    public setTorrents(torrents: Array<Torrent>): void {
        this.torrents = torrents;
    }
    @Mutation
    public setLoading(loading: boolean): void {
        this.loading = loading;
    }
    
    @Action
    public fetchTorrents(): Promise<Array<Torrent>>  {
        return new Promise((resolve, reject) => {
            axios.get('/async/torrents').then(({ data }) => {
                this.context.commit('setTorrents', data);
                
                resolve(data);
            }).catch(error => {
                reject(error);
            }).finally(() => {
                this.context.commit('setLoading', false);
            })
        });
    }
    @Action
    public stopTorrent(torrent: Torrent): Promise<Array<Torrent>>  {
        return new Promise((resolve, reject) => {
            axios.post(`/async/torrents/${torrent.id}/stop`).then(({ data }) => {
                this.context.commit('setTorrents', data);
                resolve(data);
            }).catch(error => {
                reject(error);
            });
        });
    }
    @Action
    public startTorrent(torrent: Torrent):  Promise<Array<Torrent>>  {
        return new Promise((resolve, reject) => {
            axios.post(`/async/torrents/${torrent.id}/start`).then(({ data }) => {
                this.context.commit('setTorrents', data);
                resolve(data);
            }).catch(error => {
                reject(error);
            });
        });
    }
}
export default Torrents;