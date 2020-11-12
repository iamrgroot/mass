// TODO Correct types?
// eslint-disable-next-line @typescript-eslint/no-explicit-any, @typescript-eslint/explicit-module-boundary-types
export function updateObject<T>(item: T, new_item: T): T {
    return Object.assign(
        {},
        item,
        new_item
    );
}
