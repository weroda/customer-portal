@extends('layouts.app')

@section('content')

    <a class="btn btn-primary" role="button" href="/dashboard">Go back</a>
    
    <h1>{{$ticket->title}}</h1>

    <p>{!!$ticket->body!!}</p>

    <hr>

    <small>Written on: {{$ticket->created_at}} | Written by: {{$ticket->user->name}}</small>

    <hr>

    <h2>Attachments</h2>

    @if($ticket->attachment_1 !== '')
        <span class="attachmentImageTitle">Attachment 1:</span>
        <img src="/storage/attachment_images/{{$ticket->attachment_1}}" alt="">
    @endif

    @if($ticket->attachment_2 !== '')
        <span class="attachmentImageTitle">Attachment 2:</span>
        <img src="/storage/attachment_images/{{$ticket->attachment_2}}" alt="">
    @endif
    
    @if($ticket->attachment_3 !== '')
        <span class="attachmentImageTitle">Attachment 3:</span>
        <img src="/storage/attachment_images/{{$ticket->attachment_3}}" alt="">
    @endif
    

    @if(!Auth::guest())
        @if(Auth::user()->id == $ticket->user_id)
            <a class="btn btn-primary" href="/tickets/{{$ticket->id}}/edit">Edit</a>
            
            {!!Form::open(['action' => ['TicketsController@destroy', $ticket->id], 'method' => 'POST'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif

@endsection 