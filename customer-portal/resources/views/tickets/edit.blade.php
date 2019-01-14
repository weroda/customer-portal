@extends('layouts.app')

@section('content')

    <h1>Edit ticket</h1>

    {!! Form::open(['action' => ['TicketsController@update', $ticket->id], 'method' => 'POST']) !!}
        
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', $ticket->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
                {{Form::label('body', 'Body')}}
                {{Form::textarea('body', $ticket->body, ['class' => 'form-control', 'placeholder' => 'Ticket information', 'id' => 'article-ckeditor'])}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}

    {!! Form::close() !!}

@endsection 