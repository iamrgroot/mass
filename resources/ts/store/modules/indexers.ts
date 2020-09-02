import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators';
import { IndexResult } from '@/types/Item';
import { ItemTypeArgument, ManualAddArgument } from '@/types/Args';
import axios from '@/plugins/axios';
import { ItemType } from '@/enums/ItemType';

@Module({ namespaced: true })
class Indexers extends VuexModule {
    public dialog = false;
    public loading = false;
    public indexer_results: IndexResult[] = [];

    @Mutation
    public setDialog(dialog: boolean): void {
        this.dialog = dialog;
    }
    @Mutation
    public setLoading(loading: boolean): void {
        this.loading = loading;
    }
    @Mutation
    public setIndexerResults(indexer_results: IndexResult[]): void {
        this.indexer_results = indexer_results;
    }

    @Action({ rawError: true })
    public manualSearch(args: ItemTypeArgument): Promise<IndexResult[]> {
        return new Promise((resolve, reject) => {
            this.context.commit('setDialog', true);
            this.context.commit('setLoading', true);

            const url = args.type === ItemType.Movie ?
                `/async/movies/${args.item_id}/manual-search` :
                `/async/series/${args.item_id}/manual-search`;

            axios.get(url).then(({ data }) => {
                this.context.commit('setIndexerResults', data);
                resolve(data);
            }).catch(error => {
                reject(error);
            }).finally(() => {
                this.context.commit('setLoading', false);
            });
        });
    }
    @Action({ rawError: true })
    public addManual(args: ManualAddArgument): Promise<boolean> {
        return new Promise((resolve, reject) => {
            const url = args.type === ItemType.Movie ?
                `/async/movies/${args.indexer_id}/add-manual`:
                `/async/series/${args.indexer_id}/add-manual`;

            axios.post(url, {
                guid: args.guid
            }).then(() => {
                this.context.commit('setIndexerResults', []);
                this.context.commit('setDialog', false);
                resolve(true);
            }).catch(error => {
                this.context.commit('Notifications/notify', {
                    color: 'error',
                    title: 'Error adding indexer entry',
                }, {root: true});

                reject(error);
            });
        });
    }
}
export default Indexers;