<?php

use App\Models\Request\RequestStatus;
use Illuminate\Database\Seeder;

class RequestStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'id'    => RequestStatus::REQUEST,
                'name'  => 'Request',
                'color' => 'grey',
                'icon'  => '$mdiTimerSand',
            ],
            [
                'id'    => RequestStatus::DOWNLOAD,
                'name'  => 'Downloading',
                'color' => 'primary',
                'icon'  => '$mdiDownload',
            ],
            [
                'id'    => RequestStatus::DONE,
                'name'  => 'Done',
                'color' => 'success',
                'icon'  => '$mdiCheck',
            ],
            [
                'id'    => RequestStatus::DENIED,
                'name'  => 'Denied',
                'color' => 'error',
                'icon'  => '$mdiClose',
            ],
        ];

        foreach ($statuses as $status) {
            RequestStatus::firstOrNew($status)->save();
        }
    }
}
