<?php

namespace App\Http\Controllers\Requests;

use App\Enums\ItemType;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestResource;
use App\Models\Request\Request;
use App\Models\Request\RequestStatus;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserRequestController extends Controller
{
    public function requests(): AnonymousResourceCollection
    {
        return RequestResource::collection(Auth::user()->requests);
    }

    public function put(HttpRequest $request): RequestResource
    {
        $validated = $request->validate([
            'item.tvdb_id' => 'nullable|integer',
            'item.tmdb_id' => 'nullable|integer',
            'item.text'    => 'required',
            'item.images'  => 'required|array',
        ]);

        $image_url = $validated['item']['images'][0]['url'] ?? '/images/shiba_poster.jpg';

        $tvdb_id = $validated['item']['tvdb_id'] ?? null;
        $tmdb_id = $validated['item']['tmdb_id'] ?? null;

        abort_if(null === $tmdb_id && null === $tvdb_id, Response::HTTP_UNPROCESSABLE_ENTITY);

        $type    = null === $tvdb_id ? ItemType::Movie : ItemType::Serie;
        $item_id = null === $tvdb_id ? $tmdb_id : $tvdb_id;

        $request = new Request([
            'type'              => $type,
            'item_id'           => $item_id,
            'text'              => $validated['item']['text'],
            'image_url'         => $image_url,
            'request_status_id' => RequestStatus::REQUEST,
            'created_by'        => Auth::id(),
            'updated_by'        => Auth::id(),
        ]);

        $request->save();

        return RequestResource::make($request);
    }

    public function delete(Request $request): bool
    {
        abort_if($request->created_by !== Auth::id(), Response::HTTP_FORBIDDEN);

        return $request->delete();
    }
}
