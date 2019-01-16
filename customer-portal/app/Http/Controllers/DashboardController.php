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
        $tickets =  Ticket::orderBy('created_at', 'dsc')->paginate(1000);
        $invoices = Invoice::orderBy('created_at', 'dsc')->paginate(1000);

        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $query = $request->input('query');
        $filter = $request->route('filter');
        
        /**
         * TODO: fix text query
         */
        if($filter == 'open') {
            if($query !== null) {
                return view('dashboard')->with('invoices', $invoices)->with('tickets', $tickets->where('title', 'LIKE', $query)->where('acitivity', 1));
            } else {
                return view('dashboard')->with('invoices', $invoices)->with('tickets', $tickets->where('activity'), 1);
            }            
        } elseif ($filter == 'closed') {
            if($query !== null) {
                return view('dashboard')->with('invoices', $invoices)->with('tickets', $tickets->where('title', 'LIKE', $query)->where('acitivity', 0));
            } else {
                return view('dashboard')->with('invoices', $invoices)->with('tickets', $user->tickets->where('activity', 0));
            }   
        } else {
            if($query !== null) {
                return view('dashboard')->with('invoices', $invoices)->with('tickets', $tickets->where('title', 'LIKE', $query));
            } else {
                return view('dashboard')->with('invoices', $invoices)->with('tickets', $tickets);
            }   
        }

        return view('dashboard')->with('invoices', $invoices)->with('tickets', $tickets);
        
    }


}
