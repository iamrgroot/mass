import { computed, reactive, toRefs } from '@vue/composition-api';
import axios from '@/plugins/axios';

import { ItemType } from '@/enums/ItemType';
import { Item, SearchResult } from '@/types/Item';
import { updateProfile } from '@/api/items';
import { useProfiles } from './profiles';
import { useNotifications } from './notifications';

const item_store = reactive({
    route_type: ItemType.Movie,
    item: null as Item| null,
    movies: [] as Item[],
    series: [] as Item[],
    movies_loading: false,
    series_loading: false,
    item_loading: true,
    item_adding: false,
    seasons_dialog: false,
    item_add_errors: [] as string[],
    route_item_type: ItemType.Movie,
});

const { notify } = useNotifications();

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
export const useItems = () => {
    const route_type_is_movie = computed((): boolean => item_store.route_type === ItemType.Movie);

    const item_is_movie = computed((): boolean => item_store.item?.type === ItemType.Movie);

    const fetchSeries = (): Promise<Item[]> => {
        return new Promise((resolve, reject) => {
            item_store.series_loading = true;

            axios.get('/async/series').then(({ data }) => {
                item_store.series = data;
                resolve(data);
            }).catch(error => {
                reject(error);
            }).finally(() => {
                item_store.series_loading = false;
            });
        });
    };
    const fetchMovies = (): Promise<Item[]> => {
        return new Promise((resolve, reject) => {
            item_store.movies_loading = true;

            axios.get('/async/movies').then(({ data }) => {
                item_store.movies = data;
                resolve(data);
            }).catch(error => {
                reject(error);
            }).finally(() => {
                item_store.movies_loading = false;
            });
        });
    };

    const deleteItem = (item_id: number, type: ItemType): Promise<boolean> => {
        return new Promise((resolve, reject) => {
            const url = type === ItemType.Movie ?
                `/async/movies/${item_id}/delete`:
                `/async/series/${item_id}/delete`;

            axios.delete(
                url
            ).then(() => {
                if (type === ItemType.Movie) {
                    item_store.movies = item_store.movies.filter(item => item.id !== item_id);
                } else {
                    item_store.series = item_store.series.filter(item => item.id !== item_id);
                }

                resolve(true);
            }).catch((error) => {
                reject(error);
            });
        });
    };

    const addItem = (
        item: SearchResult,
        profile: number,
        seasons: number[]|null
    ): Promise<Item> => {
        return new Promise((resolve, reject) => {
            const url = route_type_is_movie.value ?
                '/async/movies' :
                '/async/series';

            item_store.item_adding = true;

            axios.put(
                url,
                {item, profile, seasons}
            ).then(({ data }) => {
                item_store.item_add_errors = [];

                route_type_is_movie.value ?
                    item_store.movies.push(data) :
                    item_store.series.push(data);

                notify({
                    color: 'success',
                    title: 'Item added!',
                    content: 'Refresh in a second to load new data.',
                });

                resolve(data);
            }).catch(error => {
                const data = error.response.data;

                if (Array.isArray(data)) {
                    item_store.item_add_errors = data.reverse().map(item => item.errorMessage);
                    return;
                }

                reject(error);
            }).finally(() => {
                item_store.item_adding = false;
            });
        });
    };

    const toggleSeason = (item_id: number, season: number, monitor: boolean): Promise<Item> => {
        return new Promise((resolve, reject) => {
            axios.put(
                `/async/series/${item_id}/toggle-season`,
                { monitor, season}
            ).then(({ data }) => {
                item_store.item = data;

                resolve(data);
            }).catch(error => {
                reject(error);
            });
        });
    };

    const refreshItem = (item_id: number, type: ItemType): Promise<boolean> => {
        return new Promise((resolve, reject) => {
            const url = type === ItemType.Movie ?
                `/async/movies/${item_id}/refresh`:
                `/async/series/${item_id}/refresh`;

            axios.post(
                url
            ).then(() => {
                notify({
                    color: 'success',
                    title: 'Item refreshed!',
                    content: 'Item is being updated in the background.',
                });

                resolve(true);
            }).catch((error) => {
                reject(error);
            });
        });
    };

    const updateItemProfile = (item_id: number, type: ItemType, profile_id: number): Promise<void> => {
        return new Promise((resolve, reject) => {
            updateProfile(type, item_id, profile_id)
                .then(data => {
                    item_store.item = data;

                    const { profile_dialog } = useProfiles();
                    profile_dialog.value = false;

                    resolve();
                })
                .catch(error => reject(error));
        });
    };

    return {
        ...toRefs(item_store),
        route_type_is_movie,
        item_is_movie,
        fetchMovies,
        fetchSeries,
        deleteItem,
        addItem,
        toggleSeason,
        refreshItem,
        updateItemProfile,
    };
};