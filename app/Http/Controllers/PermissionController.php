<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Route;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $routes = Route::all();
        $roles = Role::all();
        
        $permissions = Permission::with(['role', 'route'])->get();
        
        $dataPermissions = [];
        
        foreach ($permissions as $permission) {
            $dataPermissions[$permission->role->name][] = $permission->route->name;
        }
        
        return view('permissions.index', compact('routes', 'roles', 'dataPermissions'));
    }
    
    public function destroy(Request $request)
    {
        $route = Route::where('name', $request->name)->firstOrFail();
        
        Permission::where('role_id', $request->role_id)
                  ->where('route_id', $route->id)
                  ->delete();
        
        return redirect('/permissions');
    }
    
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'role_id' => 'required',
            'route_id' => 'required|array',
        ]);
        
        foreach ($validatedData['route_id'] as $routeId) {
            $permissionTest = Permission::where('route_id', $routeId)
                                        ->where('role_id', $validatedData['role_id'])
                                        ->exists();
                                        
            if (!$permissionTest) {
                Permission::create([
                    'role_id' => $validatedData['role_id'],
                    'route_id' => $routeId,
                ]);
            }
        }
        
        return redirect('/permissions');
    }
}
