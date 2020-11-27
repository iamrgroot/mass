import { reactive, toRefs } from '@vue/composition-api';

const toolbar_store = reactive({
    show_toolbar: true,
});

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
export const useToolbar = () => {
    return {
        ...toRefs(toolbar_store),
    };
};