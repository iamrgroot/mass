import axios from '@/plugins/axios';
import { Profile } from '@/types/Item';

export async function getMovieProfiles(): Promise<Profile[]> {
    return (await axios.get('/async/profiles/from-movies')).data;
}

export async function getSeriesProfiles(): Promise<Profile[]> {
    return (await axios.get('/async/profiles/from-series')).data;
}
