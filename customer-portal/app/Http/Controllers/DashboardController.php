<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Ticket;
use App\Invoice;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $tickets =  Ticket::orderBy('created_at', 'dsc')->paginate(10);
        $invoices = Invoice::orderBy('created_at', 'dsc')->paginate(10);

        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $query = $request->input('query');
        $filter = $request->route('filter');
        
        if($filter == 'open') {
            if($query !== null) {
                return view('dashboard')->with('tickets', $user->tickets->where('activity', 1)->where('title', 'LIKE', $query)->with('user', $user)->with('invoices', $invoices));
            } else {
                return view('dashboard')->with('tickets', $user->tickets->where('activity', 1)->with('user', $user)->with('invoices', $invoices));
            }            
        } elseif ($filter == 'closed') {
            if($query !== null) {
                return view('dashboard')->with('tickets', $user->tickets->where('activity', 0)->where('title', 'LIKE', $query)->with('user', $user)->with('invoices', $invoices));
            } else {
                return view('dashboard')->with('tickets', $user->tickets->where('activity', 0))->with('user', $user)->with('invoices', $invoices);
            }   
        } else {
            if($query !== null) {
                return view('dashboard')->with('tickets', $user->tickets->where('title', 'CONTAINS', $query)->with('user', $user)->with('invoices', $invoices));
            } else {
                return view('dashboard')->with('tickets', $user->tickets)->with('user', $user)->with('invoices', $invoices);
            }   
        }

        return view('dashboard')->with('invoices', $invoices)->with('tickets', $tickets);
        
    }


}
