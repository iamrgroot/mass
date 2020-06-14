<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Sonarr\DownloadClient;

class TestController extends Controller
{
    public function test()
    {
        
        $connection = DB::connection('sonarr_sqlite');
        dd(DownloadClient::all());

        dd($connection);
    }
}