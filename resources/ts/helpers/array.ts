// TODO Correct types?
// eslint-disable-next-line @typescript-eslint/no-explicit-any, @typescript-eslint/explicit-module-boundary-types
export function updateArrayItem(array: any[], item: any, compare_key = 'id'): void {
    array.splice(
        array.findIndex(array_item => array_item[compare_key] === item[compare_key]),
        1,
        item
    );
}

// TODO Correct types?
// eslint-disable-next-line @typescript-eslint/no-explicit-any, @typescript-eslint/explicit-module-boundary-types
export function removeArrayItem(array: any[], item: any, compare_key = 'id'): void {
    array.splice(
        array.findIndex(array_item => array_item[compare_key] === item[compare_key]),
        1,
    );
}