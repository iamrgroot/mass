<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        try {
            DB::beginTransaction();

            /** @var User $user */
            $user = User::firstOrNew([
                'id' => User::ADMIN,
            ]);

            if (! $user->exists) {
                $user->username = 'admin';
                $user->password = bcrypt(config('app.admin_password'));
                $user->save();
            }

            $permissions = [
                'torrents.admin',
                'movies.admin',
                'series.admin',
                'movies.search',
                'series.search',
                'requests.admin',
                'requests.use',
            ];

            foreach ($permissions as $other_permission) {
                Permission::firstOrCreate(['name' => $other_permission]);
            }

            $roles = [
                'admin' => [...$permissions],
                'user'  => [
                    'movies.search',
                    'series.search',
                    'requests',
                ],
            ];

            foreach ($roles as $role => $role_permissions) {
                /** @var Role $role */
                $role = Role::firstOrCreate(['name' => $role]);

                $permissions = Permission::whereIn('name', $role_permissions)->get();

                $role->permissions()->sync($permissions);
            }

            $user->syncRoles(Role::where('name', 'admin')->firstOrFail());

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
