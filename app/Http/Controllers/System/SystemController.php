<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\System\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class SystemController extends Controller
{
    public function settings(): JsonResource
    {
        return SettingResource::collection(
            Setting::all()
        );
    }

    public function patch(Request $request): Response
    {
        $validated = $request->validate([
            'name'  => 'required|exists:App\Models\System\Setting,name',
            'value' => 'required',
        ]);

        $setting        = Setting::where('name', $validated['name'])->firstOrFail();
        $setting->value = Setting::encodeValue($validated['value'], $setting->type);
        $setting->save();

        return response('ok');
    }
}
