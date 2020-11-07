
import { computed, reactive, toRefs } from '@vue/composition-api';

import { Profile } from '@/types/Item';

import { getMovieProfiles, getSeriesProfiles } from '@/api/profiles';
import { useItems } from './items';
import { ItemType } from '@/enums/ItemType';

export const useProfiles = () => {
    const profile_store = reactive({
        movie_profiles: [] as Profile[],
        serie_profiles: [] as Profile[],
        profiles_loading: false,
        profile_dialog: false,
        relevant_profiles: computed((): Profile[] => {
            const { item } = useItems();

            if (! item.value) return [];

            return item.value.type === ItemType.Movie ? profile_store.movie_profiles : profile_store.serie_profiles;
        })
    });

    const fetchMovieProfiles = (): Promise<Profile[]> => {
        return new Promise((resolve, reject) => {
            getMovieProfiles()
                .then(data => {
                    profile_store.movie_profiles = data;
                    resolve(data);
                })
                .catch(reject);
        });
    };

    const fetchSerieProfiles = (): Promise<Profile[]>  => {
        return new Promise((resolve, reject) => {
            getSeriesProfiles()
                .then(data => {
                    profile_store.serie_profiles = data;
                    resolve(data);
                })
                .catch(reject);
        });
    };

    const initializeProfiles = (): void => {
        profile_store.profiles_loading = true;
    
        Promise.all([
            fetchMovieProfiles(),
            fetchSerieProfiles(),
        ]).then(() => {
            profile_store.profiles_loading = false;
        });
    };

    return {
        ...toRefs(profile_store),
        fetchMovieProfiles,
        fetchSerieProfiles,
        initializeProfiles,
    }
};