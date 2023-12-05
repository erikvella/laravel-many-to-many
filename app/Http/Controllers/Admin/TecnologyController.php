<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tecnology;
use App\Models\Project;
use Illuminate\Support\Str;
use App\Functions\Helper;

class TecnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tecnologies = Tecnology::all();
        return view('admin.tecnologies.index' , compact('tecnologies'));
    }


    public function projectsTecnologies(Tecnology $tecnology){
        $projects = $tecnology->projects;
        return view('admin.tecnologies.projectsTecnologies' , compact('projects' , 'tecnology'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // prima di creare una nuova tecnologia verifichiamo se esiste già
        // se esiste non creo la nuova tecnologia ma ritorno alla index
        $exist = Tecnology::where('name' , $request->name)->first();
        if($exist){
            return redirect()->route('admin.tecnologies.index')->with('error' , 'Questa tecnologia esiste già!');
        }else{
            $new_tecnology = new Tecnology();
            $new_tecnology->name = $request->name;
            $new_tecnology->slug = Str::slug($request->name , '-');
            $new_tecnology->save();
            return redirect()->route('admin.tecnologies.index')->with('success' , 'Nuova tecnologia inserita correttamente');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tecnology $tecnology)
    {
    // 1 validare il dato
    // 2 controllare se esiste un'altra tecnologia con lo stesso nome
    // 3 generare lo slug
    // 4 effettuare l'update
    // 5 reindirizzare all'index

    // 1
    $val_data = $request->validate([
        'name' => 'required|max:20|min:2',

    ],[
        'name.required' => 'Devi inserire il nome della tecnologia',
        'name.max' => 'Il nome deve contenere al massimo 20 caratteri',
        'name.min' => 'Il nome deve contenere minimo 2 caratteri',
    ]);

    // 2
    $exist = Tecnology::where('name' , $request->name)->first();
    if($exist){
     return redirect()->route('admin.tecnologies.index')->with('error' , 'Tecnologia già presente!');
    };

    // 3
    $val_data['slug'] = Helper::generateSlug($request->name ,  Tecnology::class);

    // 4
    $tecnology->update($val_data);

    // 5
    return redirect()->route('admin.tecnologies.index')->with('success' , 'Tecnologia aggiornata con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tecnology $tecnology)
    {
        $tecnology->delete();
         return redirect()->route('admin.tecnologies.index')->with('success' , 'Tecnologia eliminata correttamente');
    }
}
