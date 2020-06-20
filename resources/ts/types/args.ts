import { ItemType } from '@/enums/ItemType'
import { Item } from './item'

export type ItemTypeArgument = {
    item_id: number;
    type: ItemType;
}

export type ItemAddArgument = {
    item: Item;
    profile: number;
    seasons: Array<number>|null;
    type: ItemType;
}