import { ItemType } from '@/enums/ItemType';
import { SearchResult } from './Item';

export type ItemTypeArgument = {
    item_id: number;
    type: ItemType;
}

export type ItemAddArgument = {
    item: SearchResult;
    profile: number;
    seasons: number[]|null;
    type: ItemType;
}

export type SerieUpdateArgument = {
    item_id: number;
    season: number;
    monitor: boolean;
}

export type ManualAddArgument = {
    guid: string;
    indexer_id: number;
    type: ItemType;
}

export type ChangeProfileArgument = {
    item_type: ItemType;
    item_id: number;
    profile_id: number;
}