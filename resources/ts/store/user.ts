import { reactive, toRefs } from '@vue/composition-api';

export const useUser = () => {
    const user_store = reactive({
        user: window.user,
    });

    return {
        ...toRefs(user_store),
    };
};