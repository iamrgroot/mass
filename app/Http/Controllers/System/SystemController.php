<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\System\Setting;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemController extends Controller
{
    public function settings(): JsonResource
    {
        return SettingResource::collection(
            Setting::all()
        );
    }
}
