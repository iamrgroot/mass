<?php

use App\Models\Auth\User;
use App\Models\System\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $default_settings = [
            [
                'type'      => Setting::TYPE_BOOLEAN,
                'name'      => Setting::NAME_LOG_DISK,
                'value'     => Setting::encodeValue(false, Setting::TYPE_BOOLEAN),
                'component' => 'Switch',
            ],
            [
                'type'      => Setting::TYPE_BOOLEAN,
                'name'      => Setting::NAME_LOG_MEMORY,
                'value'     => Setting::encodeValue(false, Setting::TYPE_BOOLEAN),
                'component' => 'Switch',
            ],
            [
                'type'      => Setting::TYPE_BOOLEAN,
                'name'      => Setting::NAME_LOG_CPU,
                'value'     => Setting::encodeValue(false, Setting::TYPE_BOOLEAN),
                'component' => 'Switch',
            ],
        ];

        foreach ($default_settings as $setting) {
            $setting = Setting::firstOrNew([
                'name' => $setting['name'],
            ], [
                'type'       => $setting['type'],
                'value'      => $setting['value'],
                'component'  => $setting['component'],
                'updated_by' => User::ADMIN,
            ]);

            if (! $setting->exists) {
                $setting->save();
            }
        }
    }
}
