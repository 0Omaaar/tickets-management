<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Module;

class AdminController extends Controller
{
    public function index(Request $request){
        return view('admin.index');
    }

    public function settings(Request $request){
        $projects = [];
        $modules = [];
        try{
            if($request->has('project_search')){
                $projects = Project::where('name', 'like', '%' . $request->project_search . '%')
                ->orWhere('description', 'like', '%' . $request->project_search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(5)
                ->appends(['project_search' => $request->project_search]);
            }else{
                $projects = Project::paginate(5);
            }

            if($request->has('module_search')){
                $modules = Module::where('name', 'like', '%' . $request->module_search . '%')
                ->orWhere('description', 'like', '%' . $request->module_search . '%')
                ->orWhereHas('project', function($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->module_search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5)
                ->appends(['module_search' => $request->module_search]);
            }else{
                $modules = Module::paginate(5);
            }
        }catch(\Exception $e){
            flash()->error('Erreur lors de la récupération des données');
            return redirect()->back();
        }

        return view('admin.settings', compact('projects', 'modules'));
    }

    public function storeProject(Request $request){
        try{
            $project = new Project();
            $project->name = $request->name;
            $project->description = $request->description;
            $project->save();

            flash()->success('Projet enregistré avec succès');
            return redirect()->back();
        }catch(\Exception $e){
            flash()->error('Erreur lors de l\'enregistrement du projet');
            return redirect()->back();
        }
    }

    public function deleteProject($id){
        try{
            $project = Project::find($id);
            $project->delete();
            flash()->success('Projet supprimé avec succès');
            return redirect()->back();
        }catch(\Exception $e){
            flash()->error('Erreur lors de la suppression du projet');
            return redirect()->back();
        }
    }

    public function getProject($id){
        try{
            $project = Project::find($id);
            return response()->json(['success' => true, 'project' => $project]);
        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => 'Erreur lors de la récupération du projet']);
        }
    }

    public function updateProject(Request $request, $id){
        try{
            $project = Project::find($id);
            $project->name = $request->name;
            $project->description = $request->description;
            $project->save();

            flash()->success('Projet mis à jour avec succès');
            return redirect()->back();
        }catch(\Exception $e){
            flash()->error('Erreur lors de la mise à jour du projet');
            return redirect()->back();
        }
    }

    // Module methods
    public function storeModule(Request $request){
        try{
            $module = new Module();
            $module->name = $request->name;
            $module->description = $request->description;
            $module->project_id = $request->project_id;
            $module->save();

            flash()->success('Module enregistré avec succès');
            return redirect()->back();
        }catch(\Exception $e){
            flash()->error('Erreur lors de l\'enregistrement du module');
            return redirect()->back();
        }
    }

    public function deleteModule($id){
        try{
            $module = Module::find($id);
            $module->delete();
            flash()->success('Module supprimé avec succès');
            return redirect()->back();
        }catch(\Exception $e){
            flash()->error('Erreur lors de la suppression du module');
            return redirect()->back();
        }
    }

    public function getModule($id){
        try{
            $module = Module::find($id);
            return response()->json(['success' => true, 'module' => $module]);
        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => 'Erreur lors de la récupération du module']);
        }
    }

    public function updateModule(Request $request, $id){
        try{
            $module = Module::find($id);
            $module->name = $request->name;
            $module->description = $request->description;
            $module->project_id = $request->project_id;
            $module->save();

            flash()->success('Module mis à jour avec succès');
            return redirect()->back();
        }catch(\Exception $e){
            flash()->error('Erreur lors de la mise à jour du module');
            return redirect()->back();
        }
    }
}
