@extends('layouts.app')

@section('content')

<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <h1>Welcome, {{$user->name}}</h1>
    
                <a class="btn btn-light" href="/admin"><i class="fas fa-angle-left"></i> Return to admin page</a>
    
                {!! Form::open(['action' => ['AccountsController@update', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group">
                        {{Form::label('name', 'Name')}}
                        {{Form::text('name', $user->name, ['class' => 'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('email', 'Email')}}
                        {{Form::email('email', $user->email, ['class' => 'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('password', 'Password')}}
                        {{Form::password('password', ['class' => 'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('password-confirm', 'Confirm password')}}
                        {{Form::password('password-confirm', ['class' => 'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('role', 'Role')}}
                        {{Form::select('role', array(0 => 'User', 1 => 'Admin'), null, ['class' => 'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('hours', 'Hours')}}
                        {{Form::text('ticket_stripes', $user->ticket_stripes, ['class' => 'form-control'])}}
                    </div>

                    {{Form::hidden('_method', 'PUT')}}
                    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection 