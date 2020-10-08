export type Input = string | number | boolean | null;

export type Option = {
    id: number;
    name: string;
}

export type GeneralObject = {
    [key: string]: GeneralObject | null | number | boolean | string;
}
