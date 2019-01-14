<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class TicketsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets =  Ticket::orderBy('created_at', 'dsc')->paginate(10);
        return view('tickets.index')->with('tickets', $tickets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        /*
        * * Create new ticket
        */
        $ticket = new Ticket;
        $ticket->title = $request->input('title');
        $ticket->body = $request->input('body');
        $ticket->user_id = auth()->user()->id;
        $ticket->save();

        return redirect('/tickets')->with('success', 'Ticket Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::find($id);
        return view('tickets.show')->with('ticket', $ticket);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::find($id);

        /**
         * ! Make sure user is authorized to make changes
         * Check if the client owns the ticket
         */
        if(auth()->user()->id !== $ticket->user_id) {
            return redirect('/tickets')->with('error', 'You do not have permission to view this page.');    
        }

        return view('tickets.edit')->with('ticket', $ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        /*
        * * Create new ticket
        */
        $ticket = Ticket::find($id);
        $ticket->title = $request->input('title');
        $ticket->body = $request->input('body');
        $ticket->save();

        return redirect('/tickets')->with('success', 'Ticket Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        
        /**
         * ! Make sure user is authorized to make changes
         * Check if the client owns the ticket
         */
        if(auth()->user()->id !== $ticket->user_id) {
            return redirect('/tickets')->with('error', 'You do not have permission to view this page.');    
        }

        $ticket->delete();
        return redirect('/tickets')->with('success', 'Ticket removed successfully');
    }
}
