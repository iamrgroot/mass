import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators';
import { Item } from '@/types/item';
import { ItemTypeArgument, ItemAddArgument } from '@/types/args';
import { ItemType } from '@/enums/ItemType';
import axios from "@/plugins/axios";

@Module({ namespaced: true })
class Items extends VuexModule {
    public item: Item | null = null;
    public items: Array<Item> = [];
    public loading = false;
    public single_loading = false;
    public adding = false;
    public add_errors: Array<string> = [];


    @Mutation
    public setItems(items: Array<Item>): void {
        this.items = items;
    }
    @Mutation
    public setSingle(item: Item) {
        this.item = item;
    }
    @Mutation
    public deleteItem(item_id: number) {
        this.items = this.items.filter(item => item.id !== item_id);
    }
    @Mutation
    public setLoading(loading: boolean) {
        this.loading = loading;
    }
    @Mutation
    public setSingleLoading(single_loading: boolean) {
        this.single_loading = single_loading;
    }
    @Mutation
    public setAdding(adding: boolean) {
        this.adding = adding;
    }
    @Mutation
    public setAddErrors(add_errors: Array<string>) {
        this.add_errors = add_errors;
    }


    @Action({ rawError: true })
    public fetchItems(type: ItemType): Promise<Array<Item>> {
        return new Promise((resolve, reject) => {
            const url = type === ItemType.Movie ?
                '/async/movies' :
                '/async/series';

            this.context.commit('setLoading', true);

            axios.get(url).then(({ data }) => {
                this.context.commit('setItems', data);
                resolve(data);
            }).catch(error => {
                reject(error);
            }).finally(() => {
                this.context.commit('setLoading', false);
            })
        });
    }
    @Action({ rawError: true })
    public fetchSingleMovie(movie_id: number): Promise<Item> {
        return this.context.dispatch('fetchSingle', {
            item_id: movie_id,
            type: ItemType.Movie
        })
    }
    @Action({ rawError: true })
    public fetchSingleSerie(serie_id: number): Promise<Item> {
        return this.context.dispatch('fetchSingle', {
            item_id: serie_id,
            type: ItemType.Serie
        })
    }
    @Action({ rawError: true })
    public fetchSingle(args: ItemTypeArgument): Promise<Item> {
        return new Promise((resolve, reject) => {
            this.context.commit('setSingleLoading', true);
            this.context.commit('setSingle', null);

            const url = args.type === ItemType.Movie ?
                `/async/movies/${args.item_id}` :
                `/async/series/${args.item_id}`;

            axios.get(url).then(({ data }) => {
                if (data.id) {
                    this.context.commit('setSingle', data);
                }

                resolve(data);
            }).catch(error => {
                this.context.dispatch('notifications/notify', {
                    type: 'error',
                    title: 'Error!',
                    content: error.response.data.message || 'Internal Server Error!',
                }, {root: true});
                reject(error);
            }).finally(() => {
                this.context.commit('setSingleLoading', false);
            });
        });
    }
    @Action({ rawError: true })
    public deleteMovie(movie_id: number): Promise<boolean> {
        return this.context.dispatch('delete', {
            item_id: movie_id,
            type: ItemType.Movie
        })
    }
    @Action({ rawError: true })
    public deleteSerie(serie_id: number): Promise<boolean> {
        return this.context.dispatch('delete', {
            item_id: serie_id,
            type: ItemType.Serie
        })
    }
    @Action({ rawError: true })
    public delete(args: ItemTypeArgument): Promise<boolean> {
        return new Promise((resolve, reject) => {
            const url = args.type === ItemType.Movie ?
                `/async/movies/${args.item_id}/delete`:
                `/async/series/${args.item_id}/delete`;

            axios.delete(
                url
            ).then(() => {
                this.context.commit('deleteItem', args.item_id);
                resolve(true);
            }).catch(error => {
                this.context.dispatch('notifications/notify', {
                    type: 'success',
                    title: 'Item deletion failed!',
                    content: error.response.data.message || 'Internal Server Error!',
                }, {root: true});

                reject(false);
            });
        });
    }
    @Action({ rawError: true })
    public addItem(args: ItemAddArgument): Promise<Item> {
        return new Promise((resolve, reject) => {            
            const url = args.type === ItemType.Movie ?
                '/async/movies' :
                '/async/series';

            this.context.commit('setAdding', true);

            axios.put(url, {
                item: args.item,
                profile: args.profile,
                seasons: args.seasons
            }).then(({ data }) => {
                this.context.commit('setAddErrors', []);
                this.context.commit('setItems', data);

                this.context.dispatch('notifications/notify', {
                    type: 'success',
                    title: 'Item added!',
                    content: 'Refresh movies in a second to load new data.',
                }, {root: true});

                resolve(data);
            }).catch(error => {
                const data = error.response.data;

                if (Array.isArray(data)) {
                    this.context.commit('setAddErrors', data.reverse().map(item => item.errorMessage));
                    return;
                }

                reject(error);
            }).finally(() => {
                this.context.commit('setAdding', false);
            });
        });
    }
}
export default Items;