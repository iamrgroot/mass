import { reactive, toRefs } from '@vue/composition-api';

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
