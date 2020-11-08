<template>
    <div>
        <v-row class="ma-3">
            <ItemAdd />
        </v-row>
        <v-row class="ma-3">
            <ItemList />
        </v-row>
    </div>
</template>

<script lang="ts">
import { ItemType } from '@/enums/ItemType';
import { useItems } from '@/store/items';
import { defineComponent } from '@vue/composition-api';

import ItemList from '@/components/admin/item/List.vue';
import ItemAdd from '@/components/admin/item/Add.vue';

export default defineComponent({
    components: {
        ItemList,
        ItemAdd,
    },
    setup(props, vm) {
        const { item_type } = useItems();

        item_type.value = vm.root.$router.currentRoute.name === 'movies' ?
            ItemType.Movie :
            ItemType.Serie;

        return {
            item_type,
        };
    },
});
</script>
