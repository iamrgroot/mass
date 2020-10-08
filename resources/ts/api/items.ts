import axios from '@/plugins/axios';
import { CancelTokenSource } from 'axios';
import { ItemType } from '@/enums/ItemType';
import { SearchResult } from '@/types/Item';

let search_axios: CancelTokenSource | null = null;

export async function searchItem(search: string, type: ItemType): Promise<SearchResult[]> {
    if (search_axios !== null) search_axios.cancel();

    search_axios = axios.CancelToken.source();

    const url = type === ItemType.Movie ?
        'movies' :
        'series';

    const data = (await axios.get(`/async/${url}/${search}/search`, {
        cancelToken: search_axios.token
    })).data;

    search_axios = null;

    return data;
}