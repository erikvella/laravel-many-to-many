<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Tecnology;

class ProjectTecnologyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ad ogni ciclo estraggo random un progetto e una tecnologia e li metto in relazione
        for($i = 0 ; $i < 100 ; $i++){
            // estraggo un progetto random
            $project = Project::inRandomOrder()->first();
            // estraggo l'id della tecnologia random
            $tecnology_id = Tecnology::inRandomOrder()->first()->id;

            $project->tecnologies()->attach($tecnology_id);
        }
    }
}
