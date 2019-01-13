<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * 
     */
    public function index() 
    {
        $data = array(
            'title' => 'weroda'
        );
        return view('pages.index')->with($data);
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
