<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Ticket;
use App\Invoice;
use App\User;

class PagesController extends Controller
{
     /**
     * Shield index from guests
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * 
     */
    public function index() 
    {
        return redirect('/dashboard');
    }

    public function admin()
    {
        $users = DB::table('users')
            ->paginate(5, ['*'], 'users');


        $openTickets = DB::table('tickets')
            ->where('activity', 1)
            ->paginate(5, ['*'], 'openTickets');

        $closedTickets = DB::table('tickets')
            ->where('activity', 0)
            ->paginate(5, ['*'], 'closedTickets');

        $invoices = Invoice::all();

        return view('pages.admin')
            ->with('users', $users)
            ->with('invoices', $invoices)
            ->with('openTickets', $openTickets)
            ->with('closedTickets', $closedTickets);
    }

    public function about()
    {
        $data = array(
            'title' => 'over',
            'services' => ['webdesign', 'webdevelopment', 'seo', 'adverteren']
        );
        return view('pages.about')->with($data);
    }

    public function tickets() {
        return redirect('dashboard');
    }
    
}
