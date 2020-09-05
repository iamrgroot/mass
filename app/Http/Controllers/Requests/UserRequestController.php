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
    private const RELATIONS = ['status'];

    public function requests(): AnonymousResourceCollection
    {
        return RequestResource::collection(Request::with(self::RELATIONS)->get());
    }

    public function put(HttpRequest $request): RequestResource
    {
        $validated = $request->validate([
            'item.tvdb_id' => 'nullable|integer',
            'item.tmdb_id' => 'nullable|integer',
            'item.text'    => 'required',
            'item.images'  => 'required|array',
        ]);

        $images    = collect($validated['item']['images']);
        $image     = $images->firstWhere('coverType', 'poster');
        $image_url = $image['url'] ?? '/images/shiba_poster.jpg';

        $tvdb_id = $validated['item']['tvdb_id'] ?? null;
        $tmdb_id = $validated['item']['tmdb_id'] ?? null;

        abort_if(null === $tmdb_id && null === $tvdb_id, Response::HTTP_UNPROCESSABLE_ENTITY);

        $type    = null === $tvdb_id ? ItemType::Movie : ItemType::Serie;
        $item_id = null === $tvdb_id ? $tmdb_id : $tvdb_id;

        abort_if(Request::where('type', $type)->where('item_id', $item_id)->exists(), Response::HTTP_UNPROCESSABLE_ENTITY);

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
        $request->load(self::RELATIONS);

        return RequestResource::make($request);
    }

    public function delete(Request $request): bool
    {
        abort_if($request->created_by !== Auth::id(), Response::HTTP_FORBIDDEN);

        return $request->delete();
    }
}
