import { computed, reactive, toRefs } from '@vue/composition-api';
import axios from '@/plugins/axios';

import { ItemType } from '@/enums/ItemType';
import { Item, SearchResult } from '@/types/Item';
import { updateProfile } from '@/api/items';
import { useProfiles } from './profiles';
import { useNotifications } from './notifications';

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
export const useItems = () => {
    const item_store = reactive({
        item_type: ItemType.Movie,
        item: null as Item| null,
        items: [] as Item[],
        items_loading: false,
        item_loading: true,
        item_adding: false,
        item_add_errors: [] as string[],
        type_is_movie: computed((): boolean => item_store.item_type === ItemType.Movie),
        item_is_movie: computed((): boolean => item_store.item?.type === ItemType.Movie),
    });

    const fetchItems = (): Promise<Item[]> => {
        return new Promise((resolve, reject) => {
            const url = item_store.item_type === ItemType.Movie ?
                '/async/movies' :
                '/async/series';

            item_store.items_loading = true;

            axios.get(url).then(({ data }) => {
                item_store.items = data;
                resolve(data);
            }).catch(error => {
                reject(error);
            }).finally(() => {
                item_store.items_loading = false;
            });
        });
    };

    const fetchItem = (item_id: number, type: ItemType): Promise<Item> => {
        return new Promise((resolve, reject) => {
            item_store.item_loading = true;
            item_store.item = null;

            const url = type === ItemType.Movie ?
                `/async/movies/${item_id}` :
                `/async/series/${item_id}`;

            axios.get(url).then(({ data }) => {
                item_store.item = data;

                resolve(data);
            }).catch(error => {
                reject(error);
            }).finally(() => {
                item_store.item_loading = false;
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
                item_store.items = item_store.items.filter(item => item.id !== item_id);
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
            if (! item_store.item) {
                return;
            }

            const url = item_store.item.type === ItemType.Movie ?
                '/async/movies' :
                '/async/series';

            item_store.item_adding = true;

            axios.put(
                url,
                {item, profile, seasons}
            ).then(({ data }) => {
                item_store.item_add_errors = [];
                item_store.items.push(data);

                const { notify } = useNotifications();

                notify({
                    color: 'success',
                    title: 'Item added!',
                    content: 'Refresh movies in a second to load new data.',
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
                const { notify } = useNotifications();

                notify({
                    color: 'error',
                    title: 'Error adding indexer entry',
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
        fetchItems,
        fetchItem,
        deleteItem,
        addItem,
        toggleSeason,
        refreshItem,
        updateItemProfile,
    };
};