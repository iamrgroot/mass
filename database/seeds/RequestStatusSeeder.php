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
            ],
            [
                'id'    => RequestStatus::DOWNLOAD,
                'name'  => 'Downloading',
                'color' => 'primary',
            ],
            [
                'id'    => RequestStatus::DONE,
                'name'  => 'Done',
                'color' => 'success',
            ],
            [
                'id'    => RequestStatus::DENIED,
                'name'  => 'Denied',
                'color' => 'error',
            ],
        ];

        foreach ($statuses as $status) {
            RequestStatus::firstOrNew($status);
        }
    }
}
