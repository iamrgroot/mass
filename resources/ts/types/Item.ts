import { ItemType } from '@/enums/ItemType';

export type Profile = {
    id: number;
    name: string;
}
export type Item = {
    type: ItemType;
    id: number;
    rating: number;
    image_url: string;
    imdb_id: string;
}

export type Season = {
    monitored: boolean;
    seasonNumber: number;
}

export type SearchResult = {
    id: number;
    seasons?: Array<Season>;
}