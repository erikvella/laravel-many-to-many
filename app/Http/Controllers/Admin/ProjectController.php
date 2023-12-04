<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Type;
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
        $projects = Project::orderBy('id' , 'desc')->paginate(10);
        return view('admin.projects.index' , compact('projects'));
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
        $types = Type::all();
        return view('admin.projects.create-edit' , compact('title' , 'method' , 'route' , 'project' , 'types'));

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
        $route = route('admin.projects.update' , $project);

        return view('admin.projects.create-edit' , compact('title' , 'method' , 'route' , 'project'));

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
        // se il progetto contiene un'immagine , la devo eliminare
        if($project->image){
            Storage::disk('public')->delete($project->image);
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success' , 'Il progetto è stato eliminato correttamente');
    }
}
