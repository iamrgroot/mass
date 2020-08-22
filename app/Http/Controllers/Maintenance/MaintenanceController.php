<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class MaintenanceController extends Controller
{
    public function view()
    {
        $config = [
            'users' => User::getMaintenanceFields(),
        ];

        $route = Route::current()->parameter('route');

        abort_if(($config[$route] ?? null) === null, Response::HTTP_NOT_FOUND);

        return view('maintenance', ['config' => $config]);
    }
}
