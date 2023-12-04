<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    public function type(){
// relazione con la tabella types
// la funzione deve essere al singolare perchè il progetto ha una sola tipologia
// a questa funzione accederò come una proprietà della classe Project
        return $this->belongsTo(Type::class);
    }

    public function tecnologies(){
      return $this->belongsToMany(Tecnology::class);
    }


    protected $fillable = [
        'title' , 'type_id' , 'slug' , 'text' , 'date' , 'image' , 'image_original_name'
    ];

}
