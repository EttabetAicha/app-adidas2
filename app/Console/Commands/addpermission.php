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
    protected $description = 'Generate permissions based on existing routes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all registered routes
        $routes = Route::getRoutes();

        // Sync routes with database
        foreach ($routes as $route) {
            $uri = $route->uri();
            if (str_contains($uri, '_') || str_contains($uri, 'api') || str_contains($uri, 'csrf')) {
                continue;
            }

            RouteModel::updateOrCreate(
                ['name' => $uri],
                ['name' => $uri]
            );
        }

        if (!Role::where('name', 'Admin')->exists()) {
            Role::create(["name" => "Admin"]);
        }
        
        if (!Role::where('name', 'User')->exists()) {
            Role::create(["name" => "User"]);
        }
        
        if (!Role::where('name', 'Guest')->exists()) {
            Role::create(["name" => "Guest"]);
        }
        // Create permissions for Admin role
        $adminRole = Role::where('name', 'Admin')->first();
        $routes = RouteModel::all();
        foreach ($routes as $route) {
            Permission::updateOrCreate([
                "route_id" => $route->id,
                "role_id" => $adminRole->id
            ]);
        }

        $this->info('Permissions generated successfully.');
    }
}
