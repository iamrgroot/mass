

<script lang="ts">
import { Component, Vue, Prop } from 'vue-property-decorator';
import { sortBy } from 'lodash';
import { Item } from '@/types/Item';
import { ItemType } from '@/enums/ItemType';

@Component
export default class ItemBase extends Vue {
    private static_image_location = '/images/shiba_poster.jpg';

    isMovie(item: Item): boolean { return item.type === ItemType.Movie; }
    ratingColor(item: Item): string {
        if(item.rating >= 7) {
            return 'success';
        }
        if(item.rating >= 5) {
            return 'warning';
        }
        return 'error';
    }
    imageLink(item: Item): string { return `/async/movies/${item.id}/image?${Date.now()}` }
    imdbLink(item: Item): string { return `https://www.imdb.com/title/${item.imdb_id}`; }

}
</script>