type ObjectWithID = {
    [key: string]: number | string;
};

export function updateArrayItem(array: ObjectWithID[], item: ObjectWithID, compare_key = 'id'): void {
    array.splice(
        array.findIndex(array_item => {
            return array_item[compare_key] === array_item[compare_key];
        }),
        1,
        item
    );
}

export function removeArrayItem(array: ObjectWithID[], item: ObjectWithID, compare_key = 'id'): void {
    array.splice(
        array.findIndex(array_item => {
            return array_item[compare_key] === array_item[compare_key];
        }),
        1,
    );
}