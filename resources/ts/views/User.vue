<template>
    <v-app>
        <toolbar />

        <Main />
    </v-app>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api';

import Main from '@/views/Main.vue';
import Toolbar from '@/components/user/UserToolbar.vue';

export default defineComponent({
    components: {
        Main,
        Toolbar
    }
});
</script>
