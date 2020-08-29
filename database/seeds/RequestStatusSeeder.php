<?php

use App\Models\Request\RequestStatus;
use Illuminate\Database\Seeder;

class RequestStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'id'    => 0,
                'name'  => 'Request',
                'color' => 'grey',
            ],
            [
                'id'    => 1,
                'name'  => 'Downloading',
                'color' => 'primary',
            ],
            [
                'id'    => 2,
                'name'  => 'Done',
                'color' => 'success',
            ],
            [
                'id'    => 3,
                'name'  => 'Denied',
                'color' => 'error',
            ],
        ];

        foreach ($statuses as $status) {
            RequestStatus::firstOrNew($status);
        }
    }
}
