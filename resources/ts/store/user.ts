import { reactive, toRefs } from '@vue/composition-api';

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
export const useUser = () => {
    const user_store = reactive({
        user: window.user,
    });

    return {
        ...toRefs(user_store),
    };
};