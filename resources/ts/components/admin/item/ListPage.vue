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
    setup() {
        const { item_type } = useItems();

        return {
            item_type,
        };
    },
    created() {
        this.item_type = this.$router.currentRoute.name === 'movies' ?
            ItemType.Movie :
            ItemType.Serie;
    }
});
</script>
