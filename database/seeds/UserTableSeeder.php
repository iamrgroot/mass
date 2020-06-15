<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        /** @var User $user */
        $user = User::firstOrNew([
            'id' => User::ADMIN,
        ]);

        if (! $user->exists) {
            $user->name = 'admin';
            $user->email = 'admin@admin.com';
            $user->password = bcrypt(config('app.admin_password'));
            $user->save();
        }
    }
}
