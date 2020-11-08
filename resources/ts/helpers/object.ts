// TODO Correct types?
// eslint-disable-next-line @typescript-eslint/no-explicit-any, @typescript-eslint/explicit-module-boundary-types
export function updateObject(item: any, new_item: any): void {
    item = Object.assign(
        {},
        item,
        new_item
    );
}
