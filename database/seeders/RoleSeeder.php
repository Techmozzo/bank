<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin' => 'administrator of the platform', 'user' => 'staff'];
        foreach ($roles as $key => $role){
            Role::updateOrCreate([
                'name' => $key,
                'description' => $role
            ], []);
        }
    }
}
