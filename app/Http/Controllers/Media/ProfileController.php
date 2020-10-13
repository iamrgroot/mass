<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function fromMovies(): array
    {
        return config('profiles.from_movie');
    }

    public function fromSeries(): array
    {
        return config('profiles.from_serie');
    }
}
