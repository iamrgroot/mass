import { ItemType } from '@/enums/ItemType';

export type Profile = {
    id: number;
    name: string;
}

export type Feature = {
    color: string;
    text: string;
}

export type Episode = {
    id: number;
    season_number: number;
    episode_number: number;
}

export type Season = {
    monitored: boolean;
    season_number: number;
    episodes: Episode[];
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

export type IndexResult = {
    guid: string;
    indexer_id: number;
    quality: string;
    age: number;
    size: number;
    title: string;
    seeders: number;
    leechers: number;
    rejections: string[];
}