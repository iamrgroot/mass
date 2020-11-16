<template>
    <v-app>
        <toolbar />

        <container />
    </v-app>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api';

import Container from '@/views/Main.vue';
import Toolbar from '@/components/admin/AdminToolbar.vue';

export default defineComponent({
    components: {
        Container,
        Toolbar
    }
});
</script>
