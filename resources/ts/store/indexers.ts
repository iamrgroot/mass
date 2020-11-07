import { reactive, toRefs } from '@vue/composition-api';

import axios from '@/plugins/axios';

import { useNotifications } from '@/store/notifications';

import { IndexResult } from '@/types/Item';
import { ItemType } from '@/enums/ItemType';

export const useIndexers = () => {
    const indexer_store = reactive({
        indexer_dialog: false,
        indexer_loading: false,
        indexer_results: [] as IndexResult[]
    });


    const searchIndexersAutomatically = (item_id: number, type: ItemType): Promise<boolean> => {
        return new Promise((resolve, reject) => {
            const url = type === ItemType.Movie ?
                `/async/movies/${item_id}/search-indexer`:
                `/async/series/${item_id}/search-indexer`;

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

    function searchIndexers(item_id: number, type: ItemType): Promise<IndexResult[]> {
        return new Promise((resolve, reject) => {
            indexer_store.indexer_dialog = true;
            indexer_store.indexer_loading = true;

            const url = type === ItemType.Movie ?
                `/async/movies/${item_id}/manual-search` :
                `/async/series/${item_id}/manual-search`;

            axios.get(url).then(({ data }) => {
                indexer_store.indexer_results = data;
                resolve(data);
            }).catch(error => {
                reject(error);
            }).finally(() => {
                indexer_store.indexer_loading = false;
            });
        });
    }

    function addTorrentFromIndexer(guid: string, indexer_id: number, type: ItemType): Promise<boolean> {
        return new Promise((resolve, reject) => {
            const url = type === ItemType.Movie ?
                `/async/movies/${indexer_id}/add-manual`:
                `/async/series/${indexer_id}/add-manual`;

            axios.post(url, {
                guid: guid
            }).then(() => {
                indexer_store.indexer_results = [];
                indexer_store.indexer_dialog = false;

                resolve(true);
            }).catch(error => {
                const { notify } = useNotifications();

                notify({
                    color: 'error',
                    title: 'Error adding indexer entry',
                });

                reject(error);
            });
        });
    }

    return {
        ...toRefs(indexer_store),
        searchIndexersAutomatically,
        searchIndexers,
        addTorrentFromIndexer,
    };
};

