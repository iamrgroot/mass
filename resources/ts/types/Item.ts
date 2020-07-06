import { ItemType } from '@/enums/ItemType';

export type Profile = {
    id: number;
    name: string;
}

export type Feature = {
    color: string;
    text: string;
}

export type Season = {
    monitored: boolean;
    season_number: number;
}

export type Item = {
    type: ItemType;
    id: number;
    rating: number;
    image_url: string;
    imdb_id: string;
    features: Feature[];
    seasons?: Season[];
}

export type SearchResult = {
    id: number;
    seasons?: Season[];
}