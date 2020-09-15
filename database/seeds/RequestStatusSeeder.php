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
                'id'    => RequestStatus::APPROVED,
                'name'  => 'Approved',
                'color' => 'primary',
                'icon'  => '$mdiCheck',
            ],
            [
                'id'    => RequestStatus::DOWNLOADING,
                'name'  => 'Downloading',
                'color' => 'primary',
                'icon'  => '$mdiDownload',
            ],
            [
                'id'    => RequestStatus::DONE,
                'name'  => 'Done',
                'color' => 'success',
                'icon'  => '$mdiCloudCheck',
            ],
            [
                'id'    => RequestStatus::DENIED,
                'name'  => 'Denied',
                'color' => 'error',
                'icon'  => '$mdiClose',
            ],
            [
                'id'    => RequestStatus::ERROR,
                'name'  => 'Error',
                'color' => 'error',
                'icon'  => '$mdiAlertCircle',
            ],
        ];

        foreach ($statuses as $status) {
            RequestStatus::firstOrNew($status)->save();
        }
    }
}
