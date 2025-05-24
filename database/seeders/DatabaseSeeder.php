<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Permission\Database\Seeders\PermissionDatabaseSeeder;
use Modules\Role\Database\Seeders\RoleDatabaseSeeder;
use Illuminate\Support\Facades\Hash;
use Modules\Product\Database\Seeders\ProductDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleDatabaseSeeder::class,
            PermissionDatabaseSeeder::class,
        ]);

        try {
            $admin = new User();
            $admin->name = "admin";
            $admin->email = "admin@gmail.com";
            $admin->password = Hash::make("123asd");
            $admin->save();

            $admin->assignRole('admin');
            
            $customer = new User();
            $customer->name = "customer";
            $customer->email = "customer@gmail.com";
            $customer->password = Hash::make("123asd");
            $customer->save();

            $customer->assignRole('customer');
        } catch (Exception $e) {
        }
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
