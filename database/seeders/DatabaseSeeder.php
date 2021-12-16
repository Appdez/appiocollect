<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        //\App\Models\Provenace::factory(1)->create();
        //\App\Models\Neighborhood::factory(1)->create();
        //\App\Models\User::factory(1)->create();

         $aosp =  Role::create([
        'name' => 'aosp',
        ]);

         $admin =    Role::create([
            'name' => 'admin',
         ]);

        //app()[PermissionRegistrar::class]->forgetCachedPermissions();
         $user = User::where('uuid','66c3730c-0cc6-4c45-ab4a-724910abf924')->first();
         $roles = Role::where('name', 'admin')->get();
         $aosps = User::whereNotIn('uuid',['66c3730c-0cc6-4c45-ab4a-724910abf924'])->get();

         foreach ($aosps as $aosp) {
            $aosp->syncRoles(Role::where('name', 'aosp')->get());
         }

         $user->syncRoles($roles);

    }
}
