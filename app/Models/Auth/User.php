<?php

namespace App\Models\Auth;

use App\Http\Resources\RoleOptionResource;
use App\Models\Request\Request;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Auth\User.
 *
 * @property int                                                                                                       $id
 * @property string                                                                                                    $username
 * @property string                                                                                                    $password
 * @property string|null                                                                                               $remember_token
 * @property \Illuminate\Support\Carbon|null                                                                           $created_at
 * @property \Illuminate\Support\Carbon|null                                                                           $updated_at
 * @property \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property int|null                                                                                                  $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Auth\Permission[]                                    $permissions
 * @property int|null                                                                                                  $permissions_count
 * @property \Illuminate\Database\Eloquent\Collection|Request[]                                                        $requests
 * @property int|null                                                                                                  $requests_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Auth\Role[]                                          $roles
 * @property int|null                                                                                                  $roles_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 */
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
                'validate_edit' => fn ($_) => 'exists:users',
            ],
            'username' => [
                'validate_new'  => fn ($_) => 'required|unique:users,username',
                'validate_edit' => fn ($value) => "required|unique:users,username,{$value},username",
            ],
            'password' => [
                'validate_new'  => fn ($_) => 'required|min:8',
                'validate_edit' => fn ($_) => 'sometimes|min:8',
            ],
            'roles' => [
                'validate_new'  => fn ($_) => 'required|array',
                'validate_edit' => fn ($_) => 'required|array',
            ],
        ];
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class, 'created_by');
    }
}
