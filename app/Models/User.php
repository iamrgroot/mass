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

    public static function getMaintenanceFields(bool $options = true): array
    {
        $config = [
            'username' => [
                'component' => 'TextField',
            ],
            'password' => [
                'component'     => 'Password',
                'hide_in_table' => true,
            ],
            'roles' => [
                'component'     => 'SelectMultiple',
                'relation'      => $options ? RoleOptionResource::collection(Role::all()) : [],
                'hide_in_table' => true,
            ],
        ];

        if (false === $options) {
            $config['model'] = self::class;
            $config['relations'] = ['roles'];
        }

        return $config;
    }
}
