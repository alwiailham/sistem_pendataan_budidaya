<?php
namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User $user */
$user = Auth::user();

if ($user && $user->isAdmin()) {
    return $next($request);
}

        return redirect('/')->with('error', 'Akses ditolak!');
    }
}