<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $aosp =  Role::create([
        'name' => 'aosp',
        ]);

         $admin =    Role::create([
            'name' => 'admin',
         ]);

         $user = User::create([
            'name'=> "Administrator",
            'email' => "Admin@admin.com",
            'email_verified_at' => now(),
            'password'=> Hash::make("admin@admin"),
            'remember_token' => "66c3730c-0cc6-4c45-ab4",
         ]);

         $roles = Role::where('name', 'admin')->get();
         $user->syncRoles($roles);
        //app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
