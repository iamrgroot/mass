<?php

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        try {
            DB::beginTransaction();

            /** @var User $admin */
            $admin = User::firstOrNew([
                'id' => User::ADMIN,
            ]);

            if (! $admin->exists) {
                $admin->username = config('app.admin_user');
                $admin->password = bcrypt(config('app.admin_password'));
                $admin->save();
            }

            /** @var User $user */
            $user = User::firstOrNew([
                'id' => User::USER,
            ]);

            if (! $user->exists) {
                $user->username = config('app.user_user');
                $user->password = bcrypt(config('app.user_password'));
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

            $admin->syncRoles(Role::where('name', 'admin')->firstOrFail());
            $user->syncRoles(Role::where('name', 'user')->firstOrFail());

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
