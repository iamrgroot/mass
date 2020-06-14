import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators';
import { Profile } from '@/types/profile';
import { ItemType } from '@/enums/ItemType';
import axios from "@/plugins/axios";

@Module({ namespaced: true })
class Profiles extends VuexModule {
    public profiles: Array<Profile> = [];
    public loading = false;


    @Mutation
    public setProfiles(profiles: Array<Profile>): void {
        this.profiles = profiles;
    }
    @Mutation
    public setLoading(loading: boolean): void {
        this.loading = loading;
    }


    @Action({ rawError: true })
    public fetchProfiles(type: ItemType): Promise<Array<Profile>> {
        return new Promise((resolve, reject) => {
            const url = type === ItemType.Movie ?
                'get_movie_profiles' : 
                'get_serie_profiles';

            this.context.commit('setLoading', true);

            axios.get(url).then(({ data }) => {
                this.context.commit('setProfiles', data);

                resolve(data);
            }).catch(error => {
                reject(error);
            }).finally(() => {
                this.context.commit('setLoading', false);
            });
        });
    }

}
export default Profiles;