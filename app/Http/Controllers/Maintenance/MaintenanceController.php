<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use App\Models\User;
use Closure;
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

        $model     = $config[$table]['model'];
        $relations = $config[$table]['relations'];

        return $model::with($relations)
            ->get()
            ->map($this->mapRelations($relations));
    }

    public function update(Request $request, string $table)
    {
        $config = self::config(false)[$table];

        $model_class      = $config['model'];
        $relations        = $config['relations'];
        $fields_to_bcrypt = $config['bcrypt'] ?? [];

        unset($config['model'], $config['relations'], $config['bcrypt']);

        /** @var BaseModel|BaseUser $model */
        $model = $model_class::findOrNew($request->id);

        $validated = $this->validateData($config, $model, $request);
        $model     = $this->saveModel($model, $validated, $fields_to_bcrypt, $relations);

        return $this->mapRelations($relations)($model);
    }

    public function delete(string $table, int $model_id): Response
    {
        /** @var BaseModel|BaseUser $model */
        $model = self::config(false)[$table]['model'];

        $model::findOrFail($model_id)->delete();

        return response('ok');
    }

    private static function config(bool $to_frontend = true): array
    {
        return [
            'users' => User::getMaintenanceFields($to_frontend),
        ];
    }

    private function mapRelations(array $relations): Closure
    {
        return static function (Model $model) use ($relations) {
            foreach ($relations as $relation) {
                $model->{$relation} = $model->{$relation}->pluck('id');
                $model->unsetRelation($relation);
            }

            return $model;
        };
    }

    private function validateData(array $config, $model, Request $request): array
    {
        $keys = array_keys($config);

        $validation = array_map(static function ($item, $key) use ($model, $request) {
            $rule = $item[$model->exists ? 'validate_edit' : 'validate_new'] ?? null;

            if (null === $rule) {
                return '';
            }

            return $rule($request->get($key));
        },
            $config,
            $keys
        );

        return $request->validate(array_combine($keys, $validation));
    }

    private function saveModel($model, array $validated, array $fields_to_bcrypt, array $relations)
    {
        foreach ($validated as $field => $value) {
            if (in_array($field, $fields_to_bcrypt)) {
                $model->{$field} = bcrypt($value);
            } elseif (! is_array($value) && 'id' !== $field) {
                $model->{$field} = $value;
            }
        }

        $model->save();

        foreach ($validated as $field => $value) {
            if (is_array($value)) {
                $model->{$field}()->sync($value);
            }
        }

        $model->save();
        $model->load($relations);

        return $model;
    }
}
