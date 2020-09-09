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
import { Component, Vue } from 'vue-property-decorator';
import { ItemType } from '@/enums/ItemType';
import { namespace } from 'vuex-class';

import ItemList from '@/components/admin/item/List.vue';
import ItemAdd from '@/components/admin/item/Add.vue';

const Items = namespace('Items');

@Component({
    components: {
        ItemList,
        ItemAdd,
    }
})
export default class ListPage extends Vue {
    @Items.State public type!: ItemType;
    @Items.Mutation public setType!: (type: ItemType) => void;

    get item_type(): number {
        return this.$router.currentRoute.name === 'movies' ?
            ItemType.Movie :
            ItemType.Serie;
    }

    created(): void {
        this.setType(this.item_type);
    }
}
</script>
