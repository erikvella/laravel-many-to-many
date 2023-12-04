<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tecnology;
use Illuminate\Support\Str;

class TecnologiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['html' , 'css' , 'javascript' , 'php' , 'bootstrap' , 'scss' , 'vue' , 'laravel'];
        foreach($data as $tecnology){
            $new_tecnology = new Tecnology();
            $new_tecnology->name = $tecnology;
            $new_tecnology->slug = Str::slug($tecnology , '-');

            $new_tecnology->save();

        }
    }
}
