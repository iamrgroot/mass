import axios from '@/plugins/axios';
import { CancelTokenSource } from 'axios';
import { ItemType } from '@/enums/ItemType';
import { Item, SearchResult } from '@/types/Item';

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

export async function updateProfile(item_type: ItemType, item_id: number, profile_id: number): Promise<Item> {
    const url = item_type === ItemType.Movie ?
        `/async/movies/${item_id}/profile` :
        `/async/series/${item_id}/profile`;

    return (await axios.patch(url, { profile_id: profile_id })).data;
}