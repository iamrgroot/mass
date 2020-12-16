import { GeneralObject } from '@/types/Inputs';
import { computed, ref, SetupContext } from '@vue/composition-api';

const errors = ref({});

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
export const useMaintenance = (vm: SetupContext) => {
    const table = computed((): string => vm.root.$route.name as string);
    const fields = computed((): GeneralObject => { return {} as GeneralObject; } ); // TODO window.injected[table.value] as GeneralObject);

    return {
        errors,
        fields,
        table,
    };
};