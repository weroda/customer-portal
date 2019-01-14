@extends('layouts.app')

@section('content')

    <a class="btn btn-primary" role="button" href="/tickets">Go back</a>
    
    <h1>{{$ticket->title}}</h1>

    <p>{{$ticket->body}}</p>

    <hr>

    <small>Written on: {{$ticket->created_at}}</small>

@endsection 