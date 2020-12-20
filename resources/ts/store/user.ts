import { reactive, toRefs } from '@vue/composition-api';
import axios from '@/plugins/axios';

const user_store = reactive({
    user: null, // window.user,
    csrf_token: '',
});

const fetchUser = async (): Promise<void> => {
    user_store.user = (await axios.get('/async/user')).data;
};

const fetchCrsfToken = async (): Promise<void> => {
    user_store.csrf_token = (await axios.get('/csrf-token')).data;

    axios.defaults.headers.common = {
        'HTTP_X_REQUESTED_WITH': 'XMLHttpRequest',
        'X-CSRF-TOKEN': user_store.csrf_token,
    };
};

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
export const useUser = () => {
    return {
        ...toRefs(user_store),
        fetchCrsfToken,
        fetchUser,
    };
};