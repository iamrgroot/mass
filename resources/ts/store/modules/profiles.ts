import { VuexModule, Module, Mutation, Action } from 'vuex-module-decorators';
import { Profile } from '@/types/Item';
import { ItemType } from '@/enums/ItemType';
import axios from '@/plugins/axios';
import { ChangeProfileArgument } from '@/types/Args';

@Module({ namespaced: true })
class Profiles extends VuexModule {
    public profiles: Profile[] = [];
    public loading = false;
    public dialog = false;

    @Mutation
    public resetProfiles(): void {
        this.profiles = [];
    }
    @Mutation
    public setProfiles(profiles: Profile[]): void {
        this.profiles = profiles;
    }
    @Mutation
    public setLoading(loading: boolean): void {
        this.loading = loading;
    }
    @Mutation
    public setProfileDialog(dialog: boolean): void {
        this.dialog = dialog;
    }

    @Action({ rawError: true })
    public fetchProfiles(type: ItemType): Promise<Profile[]> {
        return new Promise((resolve, reject) => {
            const url = type === ItemType.Movie ?
                '/async/profiles/from-movies' :
                '/async/profiles/from-series';

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
    @Action({ rawError: true })
    public updateProfile(args: ChangeProfileArgument): Promise<void> {
        return new Promise((resolve, reject) => {
            const url = args.item_type === ItemType.Movie ?
                `/async/movies/${args.item_id}/profile` :
                `/async/series/${args.item_id}/profile`;

            axios.patch(url, { profile_id: args.profile_id }).then( ({ data }) => {
                this.context.commit('Items/setSingle', data, { root: true });
                this.context.commit('setProfileDialog', false);

                resolve(data);
            }).catch(error => {
                reject(error);
            });
        });
    }
}
export default Profiles;