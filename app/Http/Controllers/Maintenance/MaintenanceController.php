<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class MaintenanceController extends Controller
{
    public function view()
    {
        $config = self::config();

        $route = Route::current()->parameter('route');

        abort_if(($config[$route] ?? null) === null, Response::HTTP_NOT_FOUND);

        return view('maintenance', ['config' => $config]);
    }

    public function items(string $table): Collection
    {
        $config = self::config(false);

        abort_if(($config[$table] ?? null) === null, Response::HTTP_INTERNAL_SERVER_ERROR);

        $model = $config[$table]['model'];
        $relations = $config[$table]['relations'];

        return $model::with($relations)
            ->get()
            ->map(static function(Model $model) use ($relations) {
                foreach ($relations as $relation) {
                    $model->$relation = $model->$relation->pluck('id');
                    $model->unsetRelation($relation);
                }

                return $model;
            });
    }

    public function update(Request $request, string $table)
    {
        $config = self::config(false)[$table];

        $model = $config['model'];
        $relations = $config['relations'];

        unset($config['model']);
        unset($config['relations']);

        $validated = $request->validate(
            array_map(fn($item) => $item['validation'], $config)
        );



        dd($request->all(), $validated, $config);
    }

    private static function config(bool $to_frontend = true): array
    {
        return [
            'users' => User::getMaintenanceFields($to_frontend),
        ];
    }
}
