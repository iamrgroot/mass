import { reactive, toRefs } from '@vue/composition-api';

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
export const useLocale = () => {
    const locale_store = reactive({
        locale: 'nl'
    });

    const short_time_options: Intl.DateTimeFormatOptions = {
        hour: '2-digit',
        minute:'2-digit'
    };

    return {
        ...toRefs(locale_store),
        short_time_options,
    };
};
