<?php

namespace Modules\Permission\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Permission\Models\Permission;
use Modules\Role\Models\Role;

class PermissionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {  
        $permissions = [
            [
                'name' => 'create_product',
            ],
            [
                'name' => 'edit_product',
            ],
            [
                'name' => 'delete_product',
            ],
            [
                'name' => 'manage_product',
            ],
        ];
        try{
            collect($permissions)->each(function ($permission) {
                Permission::updateOrCreate([
                    'name' => $permission['name']
                ], $permission);
            });

            $adminRole = Role::where('name', 'admin')->first();
            $allPermissions = Permission::all()->pluck('name')->toArray();
            $adminRole->syncPermissions($allPermissions);

        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
