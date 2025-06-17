<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Module;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TicketNotification;

class AdminController extends Controller
{
    public function index(Request $request){
        $tickets = [];
        $totalTickets = 0;
        $openTickets = 0;
        $closedTickets = 0;
        $projects = [];
        $modules = [];
        $lastTickets = [];
        try{

            // get last 3 tickets submitted
            $lastTickets = Ticket::orderBy('created_at', 'desc')->take(3)->get();


            $query = Ticket::query();

            if ($request->has('search_status') && $request->search_status != '') {
                $query->where('status', $request->search_status);
            }

            if ($request->has('ticket_search') && $request->ticket_search != '') {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', "%{$request->ticket_search}%")
                      ->orWhere('description', 'like', "%{$request->ticket_search}%")
                      ->orWhere('status', 'like', "%{$request->ticket_search}%")
                      ->orWhere('priority', 'like', "%{$request->ticket_search}%")
                      ->orWhere('type', 'like', "%{$request->ticket_search}%");
                });
            }

            $tickets = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->all());


            $totalTickets = Ticket::count();
            $openTickets = Ticket::where('status', 'ouvert')->count();
            $closedTickets = Ticket::where('status', 'fermé')->count();

            $projects = Project::all();
            $modules = Module::all();
        }catch(\Exception $e){
            dd($e->getMessage());
            flash()->error('Erreur lors de la récupération des tickets');
            return redirect()->back();
        }

        return view('admin.index', compact('tickets', 'totalTickets', 'openTickets', 'closedTickets', 'projects', 'modules', 'lastTickets'));
    }

    public function settings(Request $request){
        $projects = [];
        $modules = [];
        $users = [];
        try{
            if($request->has('project_search')){
                $projects = Project::where('name', 'like', '%' . $request->project_search . '%')
                ->orWhere('description', 'like', '%' . $request->project_search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'projects_page')
                ->appends([
                    'project_search' => $request->project_search,
                    'modules_page' => $request->modules_page,
                    'users_page' => $request->users_page
                ]);
            }else{
                $projects = Project::paginate(5, ['*'], 'projects_page')
                    ->appends([
                        'modules_page' => $request->modules_page,
                        'users_page' => $request->users_page
                    ]);
            }

            if($request->has('module_search')){
                $modules = Module::where('name', 'like', '%' . $request->module_search . '%')
                ->orWhere('description', 'like', '%' . $request->module_search . '%')
                ->orWhereHas('project', function($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->module_search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'modules_page')
                ->appends([
                    'module_search' => $request->module_search,
                    'projects_page' => $request->projects_page,
                    'users_page' => $request->users_page
                ]);
            }else{
                $modules = Module::paginate(5, ['*'], 'modules_page')
                    ->appends([
                        'projects_page' => $request->projects_page,
                        'users_page' => $request->users_page
                    ]);
            }

            if($request->has('user_search')){
                $users = User::where('name', 'like', '%' . $request->user_search . '%')
                ->orWhere('email', 'like', '%' . $request->user_search . '%')
                ->orWhere('type', 'like', '%' . $request->user_search . '%')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'users_page')
                ->appends([
                    'user_search' => $request->user_search,
                    'projects_page' => $request->projects_page,
                    'modules_page' => $request->modules_page
                ]);
            }else{
                $users = User::paginate(5, ['*'], 'users_page')
                    ->appends([
                        'projects_page' => $request->projects_page,
                        'modules_page' => $request->modules_page
                    ]);
            }
        }catch(\Exception $e){
            flash()->error('Erreur lors de la récupération des données');
            return redirect()->back();
        }

        return view('admin.settings', compact('projects', 'modules', 'users'));
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

    public function updateTicketStatus($id, $status){
        try{
            $ticket = Ticket::find($id);
            $ticket->status = $status;
            $ticket->save();

            // notify ticket owner
            $ticketOwner = User::find($ticket->user);
            if($ticketOwner){
                Notification::send($ticketOwner, new TicketNotification($ticket, 'status_updated'));
            }

            flash()->success('Ticket mis à jour avec succès');
            return response()->json(['success' => true, 'message' => 'Ticket mis à jour avec succès']);
        }catch(\Exception $e){
            flash()->error('Erreur lors de la mise à jour du ticket');
            return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour du ticket']);
        }
    }

    public function getTicket($id){
        try{
            $ticket = Ticket::find($id);
            $user = User::find($ticket->user);
            return response()->json(['success' => true, 'ticket' => $ticket, 'user' => $user]);
        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => 'Erreur lors de la récupération du ticket']);
        }
    }

    public function deleteTicket($id){
        try{
            $ticket = Ticket::find($id);
            $ticket->delete();

            flash()->success('Ticket supprimé avec succès');
            return redirect()->back();
        }catch(\Exception $e){
            flash()->error('Erreur lors de la suppression du ticket');
            return redirect()->back();
        }
    }

    // User methods
    public function storeUser(Request $request){
        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->type = $request->type;
            $user->save();

            flash()->success('Utilisateur enregistré avec succès');
            return redirect()->back();
        }catch(\Exception $e){
            flash()->error('Erreur lors de l\'enregistrement de l\'utilisateur');
            return redirect()->back();
        }
    }

    public function deleteUser($id){
        try{
            $user = User::find($id);
            if($user->id === auth()->id()) {
                flash()->error('Vous ne pouvez pas supprimer votre propre compte');
                return redirect()->back();
            }
            $user->delete();
            flash()->success('Utilisateur supprimé avec succès');
            return redirect()->back();
        }catch(\Exception $e){
            flash()->error('Erreur lors de la suppression de l\'utilisateur');
            return redirect()->back();
        }
    }

    public function getUser($id){
        try{
            $user = User::find($id);
            return response()->json(['success' => true, 'user' => $user]);
        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => 'Erreur lors de la récupération de l\'utilisateur']);
        }
    }

    public function updateUser(Request $request, $id){
        try{
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->type = $request->type;
            $user->save();

            flash()->success('Utilisateur mis à jour avec succès');
            return redirect()->back();
        }catch(\Exception $e){
            flash()->error('Erreur lors de la mise à jour de l\'utilisateur');
            return redirect()->back();
        }
    }
    public function statistics()
{
    try {
        // Basic counts that should work with your existing setup
        $totalUsers = User::count();
        $totalProjects = Project::count();
        $totalTickets = Ticket::count();

        // Ticket status counts - adjust these status values to match your database
        $ticketsEnCours = Ticket::where('status', 'en_cours')->count();
        $ticketsOuverts = Ticket::where('status', 'ouvert')->count();
        $ticketsFermes = Ticket::where('status', 'fermé')->count();
        $ticketsAnnules = Ticket::where('status', 'annulé')->count();

        // Try to get admin count - but make it safe
        $adminUsers = User::where('type', 'admin')->count();
        $regularUsers = $totalUsers - $adminUsers;

        // Module counts
        $totalModules = Module::count();
        $projectsWithModules = Project::has('modules')->count(); // This is the key fix
        $modulesWithTickets = Module::has('tickets')->count();

        // Recent counts
        $recentUsers = User::where('created_at', '>=', now()->subDays(30))->count();
        $recentProjects = Project::where('created_at', '>=', now()->subDays(30))->count();
        $recentTickets = Ticket::where('created_at', '>=', now()->subDays(7))->count();
        $recentModules = Module::where('created_at', '>=', now()->subDays(30))->count();

        // Project relationships
        $projectsWithTickets = Project::has('tickets')->count();
        $highPriorityTickets = Ticket::where('priority', 'haute')->count();
        $mediumPriorityTickets = Ticket::where('priority', 'moyenne')->count();
        $lowPriorityTickets = Ticket::where('priority', 'Faible')->count();

        $bugTickets = Ticket::where('type', 'bug')->count();
        $featureTickets = Ticket::where('type', 'fonctionnalité')->count();
        $supportTickets = Ticket::where('type', 'amélioration')->count();

        $recentlyClosedTickets = Ticket::where('status', 'fermé')
            ->where('updated_at', '>=', now()->subDays(7))->count();

        // Simple monthly data
        $monthlyTickets = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyTickets[] = [
                'month' => $month->format('M Y'),
                'count' => Ticket::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count()
            ];
        }

        // Top projects - simplified
        $topProjects = Project::withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->take(5)
            ->get();

        // Top users - simplified
        $topUsers = User::withCount('tickets')
            ->orderBy('tickets_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.statistics', compact(
            'totalUsers', 'adminUsers', 'regularUsers', 'recentUsers',
            'totalProjects', 'projectsWithModules', 'projectsWithTickets', 'recentProjects',
            'totalModules', 'modulesWithTickets', 'recentModules',
            'totalTickets', 'ticketsEnCours', 'ticketsOuverts', 'ticketsFermes', 'ticketsAnnules',
            'highPriorityTickets', 'mediumPriorityTickets', 'lowPriorityTickets',
            'bugTickets', 'featureTickets', 'supportTickets',
            'recentTickets', 'recentlyClosedTickets',
            'monthlyTickets', 'topProjects', 'topUsers'
        ));

    } catch (\Exception $e) {


        flash()->error('Erreur lors de la récupération des statistiques: ' . $e->getMessage());
        return redirect()->back();
    }
}
}
