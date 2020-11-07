import { ItemType } from '@/enums/ItemType';
import { Item } from '@/types/Item';

export const useItemFeatures = () => {
    const static_image_location = '/images/shiba_poster.jpg';

    const ratingColor = (item: Item): string => {
        if (item.rating >= 7) {
            return 'success';
        }
        if (item.rating >= 5) {
            return 'warning';
        }
        return 'error';
    };

    const imageLink = (item: Item): string => {
        return item.type === ItemType.Movie ?
            `/async/movies/${item.id}/image?${Date.now()}` :
            `/async/series/${item.id}/image?${Date.now()}`;
    };

    const imdbLink = (item: Item): string => {
        return `https://www.imdb.com/title/${item.imdb_id}`;
    };

    return {
        static_image_location,
        ratingColor,
        imageLink,
        imdbLink,
    };
};