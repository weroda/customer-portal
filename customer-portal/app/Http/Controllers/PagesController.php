<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $users = User::all();
        $tickets = Ticket::all();
        $invoices = Invoice::all();
        return view('pages.admin')->with('users', $users)->with('invoices', $invoices)->with('tickets', $tickets);
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
