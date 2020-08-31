<?php

namespace App\Models\Auth;

use App\Http\Resources\RoleOptionResource;
use App\Models\Request\Request;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Notifications\Notifiable;
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
        if ($to_frontend) {
            return [
                'id' => [
                    'hide_in_table' => true,
                ],
                'username' => [
                    'component' => 'TextField',
                ],
                'password' => [
                    'component'     => 'Password',
                    'hide_in_table' => true,
                ],
                'roles' => [
                    'component'     => 'SelectMultiple',
                    'hide_in_table' => true,
                    'relation'      => RoleOptionResource::collection(Role::all()),
                ],
            ];
        }

        return [
            'model'     => self::class,
            'relations' => ['roles'],
            'bcrypt'    => ['password'],
            'id'        => [
                'validate_edit' => fn ($value) => 'exists:users',
            ],
            'username' => [
                'validate_new'  => fn ($value) => 'required|unique:users,username',
                'validate_edit' => fn ($value) => "required|unique:users,username,{$value},username",
            ],
            'password' => [
                'validate_new'  => fn ($value) => 'required|min:8',
                'validate_edit' => fn ($value) => 'optional|min:8',
            ],
            'roles' => [
                'validate_new'  => fn ($value) => 'required|array',
                'validate_edit' => fn ($value) => 'required|array',
            ],
        ];
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class, 'created_by');
    }
}
