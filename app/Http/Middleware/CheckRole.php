<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
   public function handle(Request $request, Closure $next, ...$roles)
{
    if (!Auth::check()) {
        abort(403, 'Non connecté');
    }

    if (!in_array(Auth::user()->role, $roles)) {
        abort(403, 'Votre rôle : ' . Auth::user()->role . ' | Rôle requis : ' . implode(', ', $roles));
    }

    return $next($request);
}

}
