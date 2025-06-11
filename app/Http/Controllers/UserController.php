<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Project;
use App\Models\Module;

class UserController extends Controller
{
    public function index(Request $request){
        $totalTickets =  0;
        $totalOpenTickets = 0;
        $totalClosedTickets = 0;
        $lastTickets = [];
        $projects = [];
        $modules = [];
        try{
            // get user's tickets stats
            $totalTickets = Ticket::where('user_id', auth()->user()->id)->count();
            $totalOpenTickets = Ticket::where('user_id', auth()->user()->id)->where('status', 'ouvert')->count();
            $totalClosedTickets = Ticket::where('user_id', auth()->user()->id)->where('status', 'fermé')->count();


            // get user's last 3 tickets
            $lastTickets = Ticket::where('user_id', auth()->user()->id)
                ->where('status', 'ouvert')
                ->orderBy('created_at', 'desc')->take(3)->get();

            // get user's all tickets
            if ($request->has('search')) {
                $allTickets = Ticket::where('user_id', auth()->user()->id)
                    ->where(function ($query) use ($request) {
                        $query->where('title', 'like', "%{$request->search}%")
                              ->orWhere('description', 'like', "%{$request->search}%")
                              ->orWhere('status', 'like', "%{$request->search}%")
                              ->orWhere('priority', 'like', "%{$request->search}%")
                              ->orWhere('type', 'like', "%{$request->search}%");
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(10)
                    ->appends(['search' => $request->search]);
            } else {
                $allTickets = Ticket::where('user_id', auth()->user()->id)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }

            // get projects and modules for the new ticket form
            $projects = Project::all();
            $modules = Module::all();
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Erreur lors de la récupération des tickets');
        }
        return view('user.index', compact('totalTickets', 'totalOpenTickets', 'totalClosedTickets', 'lastTickets', 'allTickets', 'projects', 'modules'));
    }

    public function storeTicket(Request $request){
        try{
            $ticket = Ticket::create([
                'user_id' => auth()->user()->id,
                'project_id' => $request->project_id,
                'module_id' => $request->module_id,
                'title' => $request->title,
                'description' => $request->description ?? null,
                'status' => $request->status,
                'priority' => $request->priority,
                'type' => $request->type,
                'image' => $request->image ?? null,
            ]);

            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/tickets/'), $imageName);
                $ticket->image = $imageName;
                $ticket->save();
            }

            return redirect()->back()->with('success', 'Ticket créé avec succès');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Erreur lors de la création du ticket');
        }
    }

    public function deleteTicket($id){
        try{
            $ticket = Ticket::find($id);
            $ticket->delete();
            return redirect()->back()->with('success', 'Ticket supprimé avec succès');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Erreur lors de la suppression du ticket');
        }
    }

    public function getTicket($id)
    {
        try {
            $ticket = Ticket::with(['project', 'module'])->findOrFail($id);
            return response()->json([
                'success' => true,
                'ticket' => $ticket
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du ticket'
            ], 500);
        }
    }

    public function updateTicket(Request $request, $id){
        try{
            $ticket = Ticket::find($id);
            $ticket->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'priority' => $request->priority,
                'type' => $request->type,
            ]);

            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/tickets/'), $imageName);
                $ticket->image = $imageName;
                $ticket->save();
            }
            return redirect()->back()->with('success', 'Ticket mis à jour avec succès');
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Erreur lors de la mise à jour du ticket');
        }
    }
}
