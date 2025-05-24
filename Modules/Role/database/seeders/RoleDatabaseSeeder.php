<?php

namespace Modules\Role\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Role\Models\Role;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
            ],
            [
                'name' => 'customer',
            ],
        ];

        try {
            collect($roles)->each(function($role){
                Role::updateOrCreate([
                    'name' => $role['name']
                ], $role);
            });
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
