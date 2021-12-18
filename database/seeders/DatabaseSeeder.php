<?php

namespace Database\Seeders;

use App\Models\Benefit;
use App\Models\Benificiary;
use App\Models\District;
use App\Models\Genre;
use App\Models\ProjectArea;
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
            'name'=> "Usuario",
            'email' => "user@user.com",
            'email_verified_at' => now(),
            'password'=> Hash::make("admin@admin"),
            'remember_token' => "66c3730c-0cc6-4c45-ab4",
         ]);

         $roles = Role::where('name', 'admin')->get();
         $user->syncRoles($roles);
         District::create([
             'name' => 'Beira'
         ]);
         District::create([
            'name' => 'Buzi'
        ]);
        District::create([
            'name' => 'Dondo'
        ]);

        Genre::create([
            'name' => "Masculino"
        ]);
        Genre::create([
            'name' => "Feminino"
        ]);

        ProjectArea::create([
            'name' => 'Food Security, Livelihood'
        ]);ProjectArea::create([
            'name' => 'Water, Sanitation and Hygiene (WASH)'
        ]);
        ProjectArea::create([
            'name' => 'Disaster Risk DRR'
        ]);
        ProjectArea::create([
            'name' => 'Shelter'
        ]);
        ProjectArea::create([
            'name' => 'Health & Psychosocial'
        ]);

        Benefit::create([
            'name' => 'Reabilitação'
        ]);

        Benefit::create([
            'name' => 'Material de construção'
        ]);
        Benefit::create([
                    'name' => 'Latrinas Melhoradas'
                ]);
        Benefit::create([
            'name' => 'Bomba de agua'
        ]);
        Benefit::create([
            'name' => 'Sessões temáticas '
        ]);
        Benefit::create([
            'name' => 'Certeza,cloro'
        ]);
        Benefit::create([
            'name' => 'Material de construção '
        ]);
        Benefit::create([
            'name' => 'Casas reselientes'
        ]);





/*
         User::factory(5)->create();
         Benefit::factory(5)->create();
         District::factory(5)->create();
         Genre::factory(5)->create();
         ProjectArea::factory(5)->create();
         Benificiary::factory(450)->create();*/
         Benificiary::factory(50)->create();

         Benificiary::all()->map(function(Benificiary $benificary){
             $benificary->project_areas()->sync(ProjectArea::all()->random(
                 collect([1,2,3,4,5])->random(1)->first()
             ));
             return $benificary;
         });
         Benificiary::all()->map(function(Benificiary $benificary){
             $benificary->benefits()->sync(Benefit::all()->random(
                 collect([1,2,3,4,5,6,7,8])->random(1)->first()
             ));
             return $benificary;
         });
        //app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
