export type SystemData = {

}

export type SettingValue = string|number|boolean;

export type Setting = {
    'name': string,
    'component': string,
    'previous_value': SettingValue,
    'value': SettingValue,
    'updated_at': string,
    'updating': boolean,
    'error': boolean,
    'success': boolean,
}