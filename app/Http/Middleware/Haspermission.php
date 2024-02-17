<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\Route;

class Haspermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $role_id = Auth::user()->role_id ?? null;
        if ($role_id) {
            $uri = $request->route()->uri;
            $allowedRoutes = Permission::where('role_id', $role_id)->get()->pluck('route.name')->toArray();
            foreach ($allowedRoutes as $allowedUri) {
                if ($this->matchRoute($uri, $allowedUri)) {
                    return $next($request);
                }
            }
            return abort(401);
        } else {
            return abort(401);
        }
    }

    /**
     * Match the URI with the allowed URI.
     *
     * @param  string  $uri
     * @param  string  $allowedUri
     * @return bool
     */
    private function matchRoute($uri, $allowedUri)
    {
        $uriSegments = explode('/', $uri);
        $allowedUriSegments = explode('/', $allowedUri);
        if (count($uriSegments) !== count($allowedUriSegments)) {
            return false;
        }
        foreach ($uriSegments as $key => $segment) {
            if ($segment !== $allowedUriSegments[$key] && $allowedUriSegments[$key] !== '*') {
                return false;
            }
        }

        return true;
    }
}
