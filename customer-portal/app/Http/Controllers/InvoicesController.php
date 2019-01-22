<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Invoice;
use App\Ticket;
use App\User;

class InvoicesController extends Controller
{

    /**
     * Authentication
     */
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $invoices = Invoice::orderBy('created_at', 'dsc')->paginate(10);
        $tickets =  Ticket::orderBy('created_at', 'dsc')->paginate(10);
        return view('dashboard')->with('tickets', $tickets)->with('invoices', $invoices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::orderBy('created_at', 'dsc')->paginate(false);

        // echo($users[0]->name);
        // echo($users[0]->id);
        // $idArray = [$users[0]->id];
        // $array = array_fill_keys($idArray, $users[0]->name);
        // echo("<br><br>");
        // var_dump($array);
        // $usersIDArray = [];
        // foreach($users as $user) {
        //     $usersIDArray.array_push($user->id);
        // }


        return view('invoices.create')->with('users', $users);
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
            'pdf' => 'required|mimes:pdf|max:1999',
        ]);

        /**
         * * Handle file upload
         */
        if($request->hasFile('pdf')) {
            // get filename with extension
            $fileNameWithExt = $request->file('pdf')->getClientOriginalName();
            // get just filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // get just extension
            $extension = $request->file('pdf')->getClientOriginalExtension();
            // filename to store
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            // upload file
            $path = $request->file('pdf')->storeAs('public/attachment_images', $fileNameToStore);
        } else {
            $fileNameToStore = '';
        }

        /**
         * * Create new invoice
         */
        $invoice = new Invoice;
        $invoice->title = $request->input('title');
        $invoice->body = $request->input('body');
        $invoice->user_id = auth()->user()->id;
        $invoice->pdf = $fileNameToStore;
        $invoice->invoice_paid = false;

        /**
         * * Save the invoice
         */
        $invoice->save();

        return redirect('/invoices')->with('success', 'Invoice Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::find($id);
        return view('invoices.show')->with('invoice', $invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id);
        /**
         * ! Make sure user is authorized to make changes
         * * Check if admin
         */
        if(auth()->user()->role !== 1) {
            return redirect('/invoices')->with('error', 'You do not have permission to edit this invoice.');
        }

        return view('invoices.edit')->with('invoice', $invoice);
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

        /**
         * * Create new invoice
         */
        $invoice = Invoice::find($id);
        $invoice->title = $request->input('title');
        $invoice->body = $request->input('body');

        /**
         * * Save the invoice
         */
        $invoice->save();

        return redirect('/invoices')->with('success', 'Invoice updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);

        /**
         * ! Make sure user is authorized to make changes
         * Check if user owns the invoice
         * TODO: check if user == admin
         */
        if(auth()->user()->id !== $invoice->user_id) {
            return redirect('/invoices')->with('error', 'You do not have permission to view this page');
        }

        /**
         * * Remove PDF from storage if it exists
         */
        if($invoice->pdf != '') {
            Storage::delete('public/attachment_images/' . $invoice->pdf);
        }

        /**
         * * Remove invoice
         */
        $invoice->delete();
        
        return redirect('/invoices')->with('success', 'Invoice removed successfully');
    }
}
