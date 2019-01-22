<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentsController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $ticket = Ticket::findOrFail($request->ticket_id);
        
        // upate user
        $userID = $ticket->user_id;
        $user = User::find($userID);
        $userTicketStripes = $user->ticket_stripes;
        $userTicketStripes = ($userTicketStripes - (float)$request->ticket_stripes_removed);
        $user->ticket_stripes = $userTicketStripes;
        $user->save();
        
        if($request->body == "") {
            return redirect()->route('tickets.show', $ticket->id)->with('error', 'Comment cannot be empty');
        }

        Comment::create([
            'body' => $request->body,
            'user_id' => Auth::id(),
            'ticket_id' => $ticket->id,
            'ticket_stripes_removed' => (float)$request->ticket_stripes_removed
        ]);
        return redirect()->route('tickets.show', $ticket->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
