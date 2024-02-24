<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Permission;

class Haspermission
{
    public function handle(Request $request, Closure $next): Response
{
    $uri = $request->route()->uri;
    $role_id = session('user_role') ?? '';

    if ($role_id) {
        $allowedRoutes = Permission::where('role_id', $role_id)->get();

        foreach ($allowedRoutes as $route) {
            $allowedUri = $route->route->name;

            if (count(explode('/', $uri)) > 2) {
                if (strstr($uri, $allowedUri))  return $next($request);
            } else {
                if ($uri === $allowedUri) return $next($request);
            }
        }

        return abort(401);
    } else {
        return redirect('/login');
    }
}

}
