<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->id = '1';
        $role->name = 'Manager';
        $role->save();

        $role = new Role();
        $role->id = '2';
        $role->name = 'Viewer';
        $role->save();
    }
}
