@extends('layouts.app')

@section('content')
    <h1>Tickets</h1>

    @if(count($tickets) > 0)
        @foreach ($tickets as $ticket)
            <a href="/tickets/{{$ticket->id}}">
                <div class="card card-body">
                    <h3>{{$ticket->title}}</h3>
                    <small>Created at: {{$ticket->created_at}}</small>
                    <p>{{$ticket->body}}</p>
                </div>
            </a>
        @endforeach
        {{$tickets->links()}}
    @else
        <p>No tickets</p>
    @endif

@endsection 