@extends('layouts.app')

@section('content')

    <a class="btn btn-primary" role="button" href="/tickets">Go back</a>
    
    <h1>{{$ticket->title}}</h1>

    <p>{!!$ticket->body!!}</p>

    <hr>

    <small>Written on: {{$ticket->created_at}} | Written by: {{$ticket->user->name}}</small>

    <hr>

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