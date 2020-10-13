<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RouteController extends Controller
{
    public function view(): View
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return $this->getView([
                '',
                'movies',
                'series',
                'movies\/\d+',
                'series\/\d+',
                'torrents',
            ], 'admin');
        }

        if ($user->hasRole('user')) {
            return $this->getView([
                '',
                'requests',
            ], 'user');
        }

        throw UnauthorizedException::forRoles(['admin', 'user']);
    }

    private function getView(array $routes, string $view): View
    {
        $route = Route::current()->parameter('route');

        if (preg_match($this->toString($routes), $route)) {
            return view($view);
        }

        abort(Response::HTTP_NOT_FOUND);
    }

    private function toString(array $array): string
    {
        return '/' . implode('|', array_map(fn ($route) => "({$route})", $array)) . '/';
    }
}
