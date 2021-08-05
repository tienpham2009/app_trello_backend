<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;

class ImageSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $image = new Image();
        $image->name = 'backgroup1.jpeg';
        $image->save();

        $image = new Image();
        $image->name = 'backgroup2.jpeg';
        $image->save();

        $image = new Image();
        $image->name = 'backgroup3.jpeg';
        $image->save();

        $image = new Image();
        $image->name = 'backgroup4.jpeg';
        $image->save();

        $image = new Image();
        $image->name = 'backgroup5.jpeg';
        $image->save();

        $image = new Image();
        $image->name = 'backgroup6.jpeg';
        $image->save();

        $image = new Image();
        $image->name = 'backgroup7.jpeg';
        $image->save();

        $image = new Image();
        $image->name = 'backgroup8.jpeg';
        $image->save();

        $image = new Image();
        $image->name = 'backgroup9.jpeg';
        $image->save();

        $image = new Image();
        $image->name = 'backgroup10.jpeg';
        $image->save();

        $image = new Image();
        $image->name = 'backgroup11.jpeg';
        $image->save();

        $image = new Image();
        $image->name = 'backgroup12.jpeg';
        $image->save();
    }
}
