@extends('layouts.app')

@section('content')

    <h1>New ticket</h1>

    {!! Form::open(['action' => 'TicketsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
                {{Form::label('body', 'Body')}}
                {{Form::textarea('body', '', ['class' => 'form-control', 'placeholder' => 'Ticket information', 'id' => 'article-ckeditor'])}}
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

        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}

    {!! Form::close() !!}
    
@endsection 