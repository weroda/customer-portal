@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <h1>Welcome, {{$user->name}}</h1>

            <a class="btn btn-light" href="/dashboard"><i class="fas fa-angle-left"></i> Return to dashboard</a>
            <br><br>
        
            {{-- Alerts --}}
            @if (session('status'))
                <div class="card">
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

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
                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}

            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
