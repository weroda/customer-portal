<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $query = $request->input('query');
        $filter = $request->route('filter');
        
        if($filter == 'open') {
            if($query !== null) {
                return view('dashboard')->with('tickets', $user->tickets->where('activity', 1)->where('title', 'LIKE', $query));
            } else {
                return view('dashboard')->with('tickets', $user->tickets->where('activity', 1));
            }            
        } elseif ($filter == 'closed') {
            if($query !== null) {
                return view('dashboard')->with('tickets', $user->tickets->where('activity', 0)->where('title', 'LIKE', $query));
            } else {
                return view('dashboard')->with('tickets', $user->tickets->where('activity', 0));
            }   
        } else {
            if($query !== null) {
                return view('dashboard')->with('tickets', $user->tickets->where('title', 'CONTAINS', $query));
            } else {
                return view('dashboard')->with('tickets', $user->tickets);
            }   
        }
        return view('dashboard')->with('tickets', $user->tickets);
        
    }


}
