<template>
    <div>
        <!-- <v-row class="ma-3">
            <item-add />
        </v-row> -->
        <v-row :class="{ 'ma-3': ! $vuetify.breakpoint.mobile }">
            <item-list />
        </v-row>
    </div>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api';

import ItemList from '@/components/admin/item/List.vue';
// import ItemAdd from '@/components/admin/item/Add.vue';

export default defineComponent({
    components: {
        ItemList,
        // ItemAdd,
    },
});
</script>
