import Vue from 'vue';
import { Profile } from '@/types/Item';
import { getMovieProfiles, getSeriesProfiles } from '@/api/profiles';

export const profile_store = Vue.observable({
    movie_profiles: [] as Profile[],
    serie_profiles: [] as Profile[],
    loading: false,
    dialog: false,
});

export async function initializeProfiles(): Promise<void>{
    const fetchMovieProfiles = new Promise((resolve, reject) => {
        getMovieProfiles()
            .then(data => {
                profile_store.movie_profiles = data;
                resolve(data);
            })
            .catch(reject);
    });

    const fetchSerieProfiles = new Promise((resolve, reject) => {
        getSeriesProfiles()
            .then(data => {
                profile_store.serie_profiles = data;
                resolve(data);
            })
            .catch(reject);
    });

    profile_store.loading = true;

    Promise.all([
        fetchMovieProfiles,
        fetchSerieProfiles,
    ]).then(() => {
        profile_store.loading = false;
    });
}