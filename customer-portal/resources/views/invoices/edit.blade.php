@extends('layouts.app')

@section('content')

    <h1>Edit invoice</h1>

    {!! Form::open(['action' => ['InvoicesController@update', $invoice->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', $invoice->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
                {{Form::label('body', 'Body')}}
                {{Form::textarea('body', $invoice->body, ['class' => 'form-control', 'placeholder' => 'Invoice information'])}}
        </div>
        <div class="form-group">
                {{Form::file('pdf')}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}

    {!! Form::close() !!}

@endsection 