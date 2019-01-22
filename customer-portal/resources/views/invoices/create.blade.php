@extends('layouts.app')

@section('content')

    <h1>New invoice</h1>

    <?php 
    echo($users[0]->name);
    echo($users[0]->id);
    $idArray = [$users[0]->id];
    $array = array_fill_keys($idArray, $users[0]->name);
    echo("<br><br>");
    var_dump($array);
    ?>

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
            {{Form::select('user', $array
                , null, ['class' => 'form-control'])}}
        </div>
        <div class="form-group">
            {{Form::label('pdf', 'Invoice')}} <br>
            {{Form::file('pdf')}}
        </div>

        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}

    {!! Form::close() !!}

@endsection 