<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Invoice;

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

    public function about()
    {
        $data = array(
            'title' => 'over',
            'services' => ['webdesign', 'webdevelopment', 'seo', 'adverteren']
        );
        return view('pages.about')->with($data);
    }
    
}
