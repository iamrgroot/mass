declare module '*.vue' {
    import Vue from 'vue';
    export default Vue;
}

// 1. Make sure to import 'vue' before declaring augmented types
import Vue from 'vue';
import { ConfirmOptions } from '@/types/ConfirmOptions';

// 2. Specify a file with the types you want to augment
//    Vue has the constructor type in types/vue.d.ts
declare module 'vue/types/vue' {
    // 3. Declare augmentation for Vue
    interface Vue {
        $confirm: (title: string, message?: string, options?: ConfirmOptions) => Promise<boolean>;
    }
}

declare global {
    interface Window { blade_errors: string[]; }
}