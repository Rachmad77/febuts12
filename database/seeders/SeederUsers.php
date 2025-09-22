<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeederUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();

        try {
            $default_user_value = [
                'password'  =>  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // default 'password'
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ];

            // create user account
            $administrator  = User::create(array_merge([
                'email'     =>  'administrator@gmail.com',
                'name'      =>  'administrator',
            ], $default_user_value));

            $admin  = User::create(array_merge([
                'email'     =>  'admin@utssurabaya.ac.id',
                'name'      =>  'admin',
            ], $default_user_value));


            //create role
            $role_administrator = Role::create(['name' => 'administrator']);
            $role_admin = Role::create(['name' => 'admin']);

            //user assign role
            $administrator->assignRole($role_administrator);

            $admin->assignRole($role_admin);

            //create permission
            $permissions = [
                'user'                  => ['read', 'create', 'update', 'delete', 'restore', 'force-delete'],
                'role'                  => ['read', 'create', 'update', 'delete', 'restore', 'force-delete'],
                'permission'            => ['read', 'create', 'update', 'delete', 'restore', 'force-delete'],

                'category-blog'         => ['read', 'create', 'update', 'delete', 'restore', 'force-delete'],

                'blog'                  => ['read', 'create', 'update', 'delete', 'restore', 'force-delete'],
            ];

            foreach ($permissions as $module => $actions) {
                foreach ($actions as $action) {
                    $permissionName = "{$module}.{$action}";
                    Permission::firstOrCreate(['name' => $permissionName]);
                }
            }

            $role_administrator->givePermissionTo(Permission::all());

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
