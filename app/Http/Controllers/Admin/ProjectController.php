<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{

    //Definisco le variabili per la validation e i relativi messaggi di errore

    protected $rules =
    [
        'title' => 'required|min:2|max:200|unique:projects',
        'description' => 'required|min:8|max:200',
        'thumb' => 'required',
        'creation_date' => 'required|date',
        'type_id'=> 'required|exists:types,id'
    ];

    protected $messages = [
        'title.required' => 'Per favore, inserire un titolo',
        'title.min' => 'Titolo troppo corto',
        'title.max' => 'Superati i 200 caratteri masssimi consentiti per il titolo',
        'title.unique' => 'Non puoi inserire un progetto esistente',

        'description.required' => 'Per favore, inserire una descrizione',
        'description.min' => 'Descrizione troppo corta, inserire almeno 8 caratteri',
        'description.max' => 'Superati i 200 caratteri masssimi consentiti per la descrizione',

        'thumb.required' => 'Path immagine non inserito',

        'creation_date.required' => 'Data creazione progetto non inserita',
        'creation_date.date' => 'La data di creazione deve essere un numero',

        'type_id.required' => 'Per favore, selezionare una tipologia',

    ];



    public function index()
    {
        $projects = Project::orderBy('creation_date', 'DESC')->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create', ["project"=> new Project(), 'types'=> Type::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$data = $request->all();
        $data = $request->validate($this->rules, $this->messages);
        $data['slug'] = Str::slug($data['title']);

        //inserisco la funzione storage per caricare il file nella cartella storage/app/public
        $data['thumb'] = Storage::put('img/', $data['thumb']);

        //controllo i valori della checkbox
        if (!isset($request->completed)){
            $data['completed'] = false;
        }          
            else {
                $data['completed'] = true;
            }   

        $newProject = new Project();
        $newProject->fill($data);
        $newProject->save();

        //ritorno all'index
        return redirect()->route('admin.projects.index')->with('message', "Project $newProject->title has been created!")->with('alert-type', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {   
        //creo due metodi per andare avanti e indietro nei progetti in ordine di data
        $nextProject = Project::where('creation_date', '>', $project->creation_date)->orderBy('creation_date')->first();
        $prevProject = Project::where('creation_date', '<', $project->creation_date)->orderBy('creation_date', 'DESC')->first();

        return view('admin.projects.show', compact('project', 'nextProject', 'prevProject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project) //Uso la dependency injection al posto di passare l'id e fare find or fail
    {
        return view('admin.projects.edit', compact('project'), ['types'=> Type::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project) //Uso la dependency injection
    {
        //richiamare la validation con i metodi creati
        
        $newRules = $this->rules;
        $newRules['title'] = ['required', 'min:2', 'max:200', Rule::unique('projects')->ignore($project->id)];
        
        $data = $request->validate($newRules, $this->messages);
       
        //controllo se l'immagine è una url o è un file locale
        if ($request->hasFile('thumb')){
            if (!$project->isImageAUrl()){
                Storage::delete($project->thumb);
            }

            //inserisco la funzione storage per caricare il file nella cartella storage/app/public
            $data['thumb'] = Storage::put('img/', $data['thumb']);
        }

        //controllo i valori della checkbox
        if (!isset($request->completed)){
            $data['completed'] = false;
        }          
            else {
                $data['completed'] = true;
            }   
        //dump($data); 

        //aggiorno i dati
         $project->update($data);

        //ritorno sulla show
        return redirect()->route('admin.projects.show', compact('project'))->with('message', "$project->title has been edited")->with('alert-type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project) //Uso la dependency injection
    {
        $project->delete();

        //mi assicuro di cancellare il file dallo storage
        if (!$project->isImageAUrl()) {
            Storage::delete($project->thumb);
        }

        //ritorno alla index
        return redirect()->route('admin.projects.index')->with('message', "$project->title has been trashed")->with('alert-type', 'danger');

    }

    //Preparo un metodo per la restore degli elementi cestinati
    public function restore($id)
    {
        Project::where('id', $id)->withTrashed()->restore();

        //ritorno alla index
        return redirect()->route('admin.projects.index')->with('message', "Project has been restored")->with('alert-type', 'success');
    }

    //Preparo un metodo per la sezione cestino - soft delete
    public function trashed()
    {
        //$projects = Project::paginate(10);
        $projects = Project::onlyTrashed()->get();
        return view('admin.projects.trash', compact('projects'));
    }

    //preparo un metodo per eliminare definitivamente il progetto
    public function forceDelete($id)
    {
        Project::where('id', $id)->withTrashed()->forceDelete();

        //ritorno alla index
        return redirect()->route('admin.projects.index')->with('message', "Project has been permamently deleted")->with('alert-type', 'success');
    }
}
