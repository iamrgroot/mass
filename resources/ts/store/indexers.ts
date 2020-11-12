import { reactive, toRefs } from '@vue/composition-api';

import axios from '@/plugins/axios';

import { useNotifications } from '@/store/notifications';

import { IndexResult } from '@/types/Item';
import { ItemType } from '@/enums/ItemType';
import { useItems } from './items';

const indexer_store = reactive({
    indexer_dialog: false,
    indexer_loading: false,
    indexer_results: [] as IndexResult[]
});

const { notify } = useNotifications();

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
export const useIndexers = () => {
    const searchIndexersAutomatically = (item_id: number, type: ItemType): Promise<boolean> => {
        return new Promise((resolve, reject) => {
            const url = type === ItemType.Movie ?
                `/async/movies/${item_id}/search-indexer`:
                `/async/series/${item_id}/search-indexer`;

            axios.post(
                url
            ).then(() => {
                notify({
                    color: 'success',
                    title: 'Indexers are being searched automagically!',
                });
                resolve(true);
            }).catch((error) => {
                notify({
                    color: 'error',
                    title: 'Error adding indexer entry',
                });
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

    function addTorrentFromIndexer(guid: string, indexer_id: number): Promise<boolean> {
        return new Promise((resolve, reject) => {
            const { route_type_is_movie } = useItems();

            const url = route_type_is_movie.value ?
                `/async/movies/${indexer_id}/add-manual`:
                `/async/series/${indexer_id}/add-manual`;

            axios.post(url, {
                guid: guid
            }).then(() => {
                indexer_store.indexer_results = [];
                indexer_store.indexer_dialog = false;

                notify({
                    color: 'success',
                    title: 'Torrent added!',
                });

                resolve(true);
            }).catch(error => {
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

