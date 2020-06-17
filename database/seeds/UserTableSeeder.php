<?php

use App\Models\User;
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
            $user->username = 'admin';
            $user->password = bcrypt(config('app.admin_password'));
            $user->save();
        }
    }
}
