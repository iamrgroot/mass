<?php

namespace App\Http\Controllers;

use App\Models\Sonarr\Indexer;

class TestController extends Controller
{
    public function test()
    {
        dd(Indexer::all());
    }
}