<?php

namespace App\Http\Controllers\Requests;

use App\Http\Controllers\Controller;
use App\Http\Resources\RequestResource;
use App\Models\Request\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminRequestController extends Controller
{
    public function updateStatus(Request $request, int $status_id): JsonResource
    {
        $request->request_status_id = $status_id;
        $request->save();

        $request->load(UserRequestController::RELATIONS);

        return RequestResource::make($request);
    }
}
