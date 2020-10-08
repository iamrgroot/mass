<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function image(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url',
        ]);

        $image = Http::get($validated['url'])->body();

        return Image::make($image)->response();
    }
}
