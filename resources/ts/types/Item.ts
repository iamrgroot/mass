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
    profile_id: number;
    features: Feature[];
    seasons?: Season[];
}

export type Image = {
    coverType: string;
    url: string;
}

export type SearchResult = {
    tvdb_id?: number;
    tmdb_id?: number;
    title: string;
    title_slug: string;
    year: string;
    text: string;
    images: Image[];
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