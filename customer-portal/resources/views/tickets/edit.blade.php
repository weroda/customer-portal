@extends('layouts.app')

@section('content')

    <h1>Edit ticket</h1>

    {!! Form::open(['action' => ['TicketsController@update', $ticket->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
                {{Form::label('activity', 'Open')}} <br>
                {{Form::checkbox('activity', 'Open', $ticket->activity)}}
        </div>
        <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', $ticket->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
                {{Form::label('body', 'Body')}}
                {{Form::textarea('body', $ticket->body, ['class' => 'form-control', 'placeholder' => 'Ticket information'])}}
        </div>
        <div class="form-group">
                {{Form::file('attachment_1')}}
        </div>
        <div class="form-group">
                {{Form::file('attachment_2')}}
        </div>
        <div class="form-group">
                {{Form::file('attachment_3')}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}

    {!! Form::close() !!}

@endsection 