<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_tecnology', function (Blueprint $table) {
            // colonna in relazione con projects
           $table->unsignedBigInteger('project_id');
            //  creazione della foreign key della colonna project_id
            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                //   se viene cancellato un progetto viene eliminata la relazione con le tecnologie nella tabella ponte
                  ->cascadeOnDelete();

        // colonna in relazione con tecnologies
        $table->unsignedBigInteger('tecnology_id');
        // creazione della foreign key della colonna tecnology_id
        $table->foreign('tecnology_id')
              ->references('id')
              ->on('tecnologies')
              //   se viene cancellato un progetto viene eliminata la relazione con i progetti nella tabella ponte
              ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_tecnologies');
    }
};
