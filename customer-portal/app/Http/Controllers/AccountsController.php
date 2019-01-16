<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class AccountsController extends Controller
{

    /**
     * Check for authentication
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        return view('account')->with('user', $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('accounts.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        /**
         * ! Make sure user is admin
         */
        if(auth()->user()->role !== 1) {
            return redirect('/dashboard')->with('error', 'You do not have permission to view this page');
        }

        return view('accounts.edit')->with('user', $user);
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
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable',
            'password-confirm' => 'nullable',
            'role' => 'nullable'
        ]);

        /*
        * * Create new user
        */
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        // password check
        $password = $request->input('password');
        $passwordConfirm = $request->input('password-confirm');
        if($password == $passwordConfirm) {
            // hash password
            $user->password = Hash::make($password);
        } else {
            return redirect('/account')->with('error', 'Passwords do not match');    
        }

        if($request->input('role') !== '') {
            $user->role = $request->input('role');
        }

        $user->save();

        /**
         * ! Check if use is admin to redirect to admin page
         */
        if(auth()->user()->role == 1) {
            return redirect('/admin')->with('success', 'Account information updated successfully');
        }

        return redirect('/account')->with('success', 'Account information updated successfully');
    }

    public function toggleCard() {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        $currentActivity = $user->ticket_stripes_activity;
        $setActivity = 'active';
        if($currentActivity == 'active') {
            $setActivity = 'inactive';
        } else {
            $setActivity = 'active';
        }

        $user->ticket_stripes_activity = $setActivity;
        $user->user_role = 0;
        $user->save();
        return redirect('/dashboard')->with('success', 'Your card hours has been updated to: ' . $setActivity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        /**
         * ! Make sure user is admin
         */
        if(auth()->user()->role !== 1) {
            return redirect('/dashboard')->with('error', 'You do not have permission to view this page');
        }

        $user->delete();
        return redirect('/admin')->with('success', 'User removed successfully');
    }
}
