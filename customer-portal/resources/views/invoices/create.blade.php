@extends('layouts.app')

@section('content')

    <h1>New invoice</h1>

    {!! Form::open(['action' => 'InvoicesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', '', ['class' => 'form-control', 'placeholder' => 'Invoice information', 'id' => 'article-ckeditor'])}}
        </div>
        <div class="form-group">
            {{Form::label('user', 'User')}}
            {{Form::select('user', $dropdown, '', ['class' => 'form-control'])}}

        </div>
        <div class="form-group">
            {{Form::label('pdf', 'Invoice')}} <br>
            {{Form::file('pdf')}}
        </div>

        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}

    {!! Form::close() !!}

@endsection 