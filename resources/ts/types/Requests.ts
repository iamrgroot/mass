import { ItemType } from '@/enums/ItemType';

export type Request = {
    id: number;
    image_url: string;
    type: ItemType;
    text: string;
    created_at: number;
    updated_at: number;
}