<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Role;
class PermissionController extends Controller
{
    public function index(){
        $Routes = Route::all();
        $Roles = Role::all();
        $permissions = Permission::all();
        $dataPermissions=[];
        foreach($permissions as $permission){
            $role = Role::where('id',$permission->role_id)->first();
            $route = Route::where('id',$permission->route_id)->first();
            $dataPermissions[$role->name][]=$route->name;
        }
        return view('permissions.index', compact('Routes','Roles','dataPermissions'));
    }
    public function create(){
        $Routes = Route::all();
        $roles = Role::all();
        return view('permissions.create', compact('Routes','roles'));
    }
    public function destroy(Request $request){
        $route=Route::where('name',$request->name)->first();
        Permission::where('role_id',$request->role_id)->where('route_id',$route->id)->delete();
        return redirect('/permission');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'role_id' => 'required',
            'route_id' => 'required',
        ]);
        foreach($validatedData['route_id'] as $route_id){
            $permissionTest=Permission::where('route_id',$route_id)->where('role_id',$validatedData['role_id'])->count();
            if($permissionTest==0){
                $permission = new Permission();
                $permission->role_id =  $validatedData['role_id'];
                $permission->route_id =  $route_id;
                $permission->save();
            }
        }
        return redirect('/permission');
    }
}
