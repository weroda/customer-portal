<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Ticket;
use App\Invoice;

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
    public function index(Request $request)
    {
        $tickets =  Ticket::orderBy('created_at', 'dsc')->paginate(10);
        $invoices = Invoice::orderBy('created_at', 'dsc')->paginate(10);
        return view('dashboard')->with('invoices', $invoices, 'tickets', $tickets);
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
            'body' => 'required',
            // Image max: 1999 [default apache 2MB]
            'attachment_1' => 'image|nullable|max:1999',
            'attachment_2' => 'image|nullable|max:1999',
            'attachment_3' => 'image|nullable|max:1999',
        ]);

        /**
         * * Handle file upload
         */
        // attachment 1
        if($request->hasFile('attachment_1')) {
            // get filename with extension
            $fileNameWithExt = $request->file('attachment_1')->getClientOriginalName();
            // get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // get just extension
            $extension = $request->file('attachment_1')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore_1 = $fileName . '_' . time() . '.' . $extension;
            // upload image
            $path = $request->file('attachment_1')->storeAs('public/attachment_images', $fileNameToStore_1);
        } else {
            $fileNameToStore_1 = '';
        }
        // attachment 2
        if($request->hasFile('attachment_2')) {
            // get filename with extension
            $fileNameWithExt = $request->file('attachment_2')->getClientOriginalName();
            // get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // get just extension
            $extension = $request->file('attachment_2')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore_2 = $fileName . '_' . time() . '.' . $extension;
            // upload image
            $path = $request->file('attachment_2')->storeAs('public/attachment_images', $fileNameToStore_2);
        } else {
            $fileNameToStore_2 = '';
        }
        // attachment 3
        if($request->hasFile('attachment_3')) {
            // get filename with extension
            $fileNameWithExt = $request->file('attachment_3')->getClientOriginalName();
            // get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // get just extension
            $extension = $request->file('attachment_3')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore_3 = $fileName . '_' . time() . '.' . $extension;
            // upload image
            $path = $request->file('attachment_3')->storeAs('public/attachment_images', $fileNameToStore_3);
        } else {
            $fileNameToStore_3 = '';
        }

        /*
        * * Create new ticket
        */
        $ticket = new Ticket;
        $ticket->title = $request->input('title');
        $ticket->body = $request->input('body');
        $ticket->user_id = auth()->user()->id;
        $ticket->attachment_1 = $fileNameToStore_1;
        $ticket->attachment_2 = $fileNameToStore_2;
        $ticket->attachment_3 = $fileNameToStore_3;
        $ticket->activity = true;

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
        $tickets =  Ticket::orderBy('created_at', 'dsc')->paginate(10);
        return view('tickets.show')->with('ticket', $ticket, 'tickets', $tickets);
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
        $tickets =  Ticket::orderBy('created_at', 'dsc')->paginate(10);

        /**
         * ! Make sure user is authorized to make changes
         * Check if the client owns the ticket
         */
        if(auth()->user()->id !== $ticket->user_id) {
            return redirect('/tickets')->with('error', 'You do not have permission to view this page.');    
        }

        return view('tickets.edit')->with('ticket', $ticket, 'tickets', $tickets);
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
        
        // ticket activity check
        $activity = true;
        if($request->input('activity') == null) {
            $activity = false;
        }
        $ticket->activity = $activity;
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

        if($ticket->attachment_1 != '') {
            Storage::delete('public/attachment_images/' . $ticket->attachment_1);
        }

        $ticket->delete();
        return redirect('/tickets')->with('success', 'Ticket removed successfully');
    }
}
