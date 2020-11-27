import { Item } from '@/types/Item';

// TODO correct type?
// eslint-disable-next-line @typescript-eslint/explicit-function-return-type, @typescript-eslint/explicit-module-boundary-types
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

    const imdbLink = (item: Item): string => {
        return `https://www.imdb.com/title/${item.imdb_id}`;
    };

    return {
        static_image_location,
        ratingColor,
        imdbLink,
    };
};