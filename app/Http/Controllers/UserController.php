<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Project;
use App\Models\Module;

class UserController extends Controller
{
    public function index(){
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
            $allTickets = Ticket::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();


            // get projects and modules for the new ticket form
            $projects = Project::all();
            $modules = Module::all();
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Erreur lors de la récupération des tickets');
        }
        return view('user.index', compact('totalTickets', 'totalOpenTickets', 'totalClosedTickets', 'lastTickets', 'allTickets', 'projects', 'modules'));
    }


    public function storeTicket(Request $request){
        dd($request->all());
        try{

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Erreur lors de la création du ticket');
        }
    }
}
