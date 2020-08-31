<?php

namespace App\Http\Controllers\Requests;

use App\Enums\ItemType;
use App\Http\Controllers\Controller;
use App\Models\Request\Request;
use App\Models\Request\RequestStatus;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserRequestController extends Controller
{
    public function requests(): Collection
    {
        return Auth::user()->requests;
    }

    public function put(): Request
    {
        $request = new Request([
            'request_status_id' => RequestStatus::REQUEST,
            'item_id'           => 1,
            'type'              => ItemType::Movie,
            'created_by'        => Auth::id(),
            'updated_by'        => Auth::id(),
        ]);

        $request->save();

        return $request;
    }

    public function delete(Request $request): bool
    {
        return $request->delete();
    }
}
