<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'tien';
        $user->email = 'tien@gmail.com';
        $user->password = Hash::make(123456);
        $user->save();

        $user = new User();
        $user->name = 'tu';
        $user->email = 'tu@gmail.com';
        $user->password = Hash::make(123456);
        $user->save();

        $user = new User();
        $user->name = 'duong';
        $user->email = 'duong@gmail.com';
        $user->password = Hash::make(123456);
        $user->save();

    }
}
