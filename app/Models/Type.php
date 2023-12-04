<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
// relazione con la tabella projects
// creo una funzione con il nome della tabella e all'interno definisco l'appartenenza
// ogni tipologia ha tanti progetti
// a questa funzione accederò come una proprietà della classe Type
    public function projects(){
        return $this->hasMany(Project::class);
    }

    protected $fillable = [
        'name' , 'slug'
    ];
}
