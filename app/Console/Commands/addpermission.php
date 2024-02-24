<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Route as RouteModel;
use Illuminate\Support\Facades\Route;

class AddPermission extends Command
{
     /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $routes = Route::getRoutes();
        // RouteModel::truncate();
        // Permission::truncate();
        foreach($routes as $route){
            $uri = $route->uri();
            if(strstr($uri, '_')) continue;
            if(strstr($uri, 'api')) continue;
            if(strstr($uri, 'csrf')) continue;
            $routeModel =  new RouteModel();
            $routeModel->name = $uri;
            $routeModel->save();  
        }
        
        if(Role::count()==0){
            Role::create(["name"=>"Admin"]);
            Role::create(["name"=>"User"]);
            Role::create(["name"=>"Guest"]);
        }
        $modelRoutes = RouteModel::all();
        $adminRole = Role::where('name', 'Admin')->first();
        foreach ($modelRoutes as $route) {
            Permission::create([
                "route_id" => $route->id,
                "role_id" => $adminRole->id
            ]);
        }
    }
}
