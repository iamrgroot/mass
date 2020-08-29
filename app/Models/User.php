<?php

namespace App\Models;

use App\Http\Resources\RoleOptionResource;
use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends BaseUser
{
    use Notifiable;
    use HasRoles;

    public const ADMIN = 1;
    public const USER  = 2;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getMaintenanceFields(bool $to_frontend = true): array
    {
        $config = [
            'id' => [
                'hide_in_table' => true,
                'validation' => $to_frontend ? '' : 'required|unique:users,username'
            ],
            'username' => [
                'component' => 'TextField',
                'validation' => $to_frontend ? '' : 'required|unique:users,username'
            ],
            'password' => [
                'component'     => 'Password',
                'hide_in_table' => true,
                'validation' => $to_frontend ? '' : 'nullable|min:8'
            ],
            'roles' => [
                'component'     => 'SelectMultiple',
                'hide_in_table' => true,
                'validation' => $to_frontend ? '' : 'array'
            ],
        ];

        if($to_frontend) {
            $config['roles']['relation'] = RoleOptionResource::collection(Role::all());
        } else {
            $config['model'] = self::class;
            $config['relations'] = ['roles'];
        }

        return $config;
    }
}
