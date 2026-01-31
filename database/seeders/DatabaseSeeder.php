<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $permissions = [
            'create-products',
            'view-products',
            'edit-products',
            'delete-products',
        ];

        $roles = [
            'admin',
            'staff',
            'viewer'
        ];

        foreach($permissions as $permission){
            Permission::create([
                'name' => $permission
            ]);
        }

        foreach($roles as $role){
            Role::create([
                'name' => $role
            ]);
        }

        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo(Permission::all());

        $staffRole = Role::where('name', 'staff')->first();
        $staffRole->givePermissionTo([
            'create-products', 
            'view-products', 
            'edit-products'
        ]);

        $viewerRole = Role::where('name', 'viewer')->first();
        $viewerRole->givePermissionTo([
            'view-products'
        ]);

        $admin = User::factory()->state([
            'name' => 'Ali Admin',
            'email' => 'ali@gmail.com',
        ])
        ->hasProducts(10)
        ->create();

        $admin->assignRole('admin');

        $staff = User::factory()->state([
            'name' => 'Sara Staff',
            'email' => 'sara@gmail.com',
        ])
        ->hasProducts(5)
        ->create();

        $staff->assignRole('staff');

        $viewer = User::factory()->state([
            'name' => 'Vera Viewer',
            'email' => 'vera@yahoo.com',
        ])
        ->hasProducts(3)
        ->create();

        $viewer->assignRole('viewer');
    }
}
