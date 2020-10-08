import { ItemType } from '@/enums/ItemType';

export function getImageURL(type: ItemType, url: string): string {
    // TVDB protects against direct usage of images on sites. So get it via our own server.
    if (type === ItemType.Serie) {
        return '/image?url=' + encodeURIComponent(url.replace('http://', 'https://'));
    }

    return url.replace('http://', 'https://');
}