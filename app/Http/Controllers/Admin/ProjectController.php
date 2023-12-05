<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Type;
use App\Models\Tecnology;
use App\Http\Requests\ProjectRequest;
use App\Functions\Helper;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_GET['toSearch'])){

            $project = Project::where('title' , 'LIKE' , '%' , $_GET['toSearch'] , '%')->paginate(20);
        }else{

            $projects = Project::orderBy('id' , 'desc')->paginate(20);
        }

       $direction = 'desc';

        return view('admin.projects.index' , compact('projects' , 'direction'));
    }

    public function orderBy($direction , $column){
        // se mi arriva in questo modo ogni volta che clicco inverto la direction
      $direction = $direction == 'desc' ? 'asc' : 'desc' ;
    //   se inverti l'ordine di $column e $direction nella tonda da errore php
      $projects = Project::orderBy( $column , $direction)->paginate(20);
      return view('admin.projects.index' , compact('projects' , 'direction'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Crea un nuovo progetto';
        $method = 'POST';
        $route = route('admin.projects.store');
        $project = null;
        $tecnologies = Tecnology::all();
        $types = Type::all();
        return view('admin.projects.create-edit' , compact('title' , 'method' , 'route' , 'project' , 'types' , 'tecnologies'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $form_data = $request->all();
        $form_data['slug'] = Helper::generateSlug($form_data['title'] , Project::class);
        $form_data['date'] = date('Y/m/d');

//  se esiste la chiave image salvo l'immagine nel filesystem e nel database
if(array_key_exists('image' , $form_data)){

// prima di salvare il file prendo il nome del file per salvarlo nel mio DB
    $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();

// salvo l'immagine nel database rinominandolo secondo l'algoritmo di laravel
    $form_data['image'] = Storage::put('uploads', $form_data['image']);

}

$new_project = Project::create($form_data);

// se trovo la chiave 'tecnologies' significa che sono stati selzionate delle tecnologie
// questa operazione la si fa dopo aver create un nuovo elemento
if(array_key_exists('tecnologies' , $form_data)){
$new_project->tecnologies()->attach($form_data['tecnologies']);
}



        return redirect()->route('admin.projects.show' , $new_project);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show' , compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $title = 'Modifica il progetto';
        $method = 'PUT';
        $types = Type::all();
        $tecnologies = Tecnology::all();
        $route = route('admin.projects.update' , $project);

        return view('admin.projects.create-edit' , compact('title' , 'method' , 'route' , 'project' , 'types' , 'tecnologies'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $form_data = $request->all();
        if($form_data['title'] !== $project->title){
            $form_data['slug'] = Helper::generateSlug($form_data['title'] , Project::class);
        }else{
            $form_data['slug'] = $project->slug;
        }

        if(array_key_exists('image' , $form_data)){
            // se esiste la chiave image vuol dire che devo sostituire l'immagine presente (se c'è) eliminando quella vecchia
            if($project->image){
            // se era presente la elimino nella storage
               Storage::disk('public')->delete($project->image);
            }

            // prima di salvare il file prendo il nome del file per salvarlo nel mio DB
            $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();

            // salvo l'immagine nel database rinominandolo secondo l'algoritmo di laravel
            $form_data['image'] = Storage::put('uploads', $form_data['image']);

        }

        $form_data['date'] = date('Y/m/d');
        $project->update($form_data);

        if(array_key_exists('tecnologies' , $form_data)){
            // aggiorno le relazioni tra i post e i tag eliminando le eventuali relazioni che sono state tolte e aggiundendo le nuove
            // sync accetta un array creando tutte le relazioni tra i progetti e le tecnologie ed eliminando le eventuali relazioni che sono state tolte
             $project->tecnologies()->sync($form_data['tecnologies']);
        }else{
           $project->tecnologies()->detach();
        }

        return redirect()->route('admin.projects.show' , $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        // non elimino le relazioni tra progetti e tecnologie perchè nella migration ho messo: cascadeOnDelete();
// altrimenti avrei dovuto scrivere questo: $project->tecnologies()->detach();


        // se il progetto contiene un'immagine , la devo eliminare
        if($project->image){
            Storage::disk('public')->delete($project->image);
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success' , 'Il progetto è stato eliminato correttamente');
    }
}
