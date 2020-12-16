<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function csrfToken(): string
    {
        return csrf_token();
    }

    public function user(): array
    {
        $user = Auth::user();

        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }
}
