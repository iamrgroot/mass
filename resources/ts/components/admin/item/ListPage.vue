<template>
    <div>
        <v-row class="ma-3">
            <ItemAdd
                :type="type"
            />
        </v-row>
        <v-row class="ma-3">
            <ItemList
                :type="type"
            />
        </v-row>
    </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { ItemType } from '@/enums/ItemType';

import ItemList from '@/components/admin/item/List.vue';
import ItemAdd from '@/components/admin/item/Add.vue';

@Component({
    components: {
        ItemList,
        ItemAdd,
    }
})
export default class ListPage extends Vue {
    public get type(): number {
        return this.$router.currentRoute.name === 'movies' ?
            ItemType.Movie :
            ItemType.Serie;
    }
}
</script>
