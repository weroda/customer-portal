@extends('layouts.app')

@section('content')

<h1>Admin</h1>

<h3>Accounts</h3>
<div class="card">
    <div class="card-content">
        @if(count($users) > 0)
        <table class="table">
            <tr>
                <th>Name</th>
                <th>#ID</th>
                <th>Email</th>
                <th>Hours</th>
                <th>Card activity</th>
                <th>Role</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>#{{$user->id}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->ticket_stripes}}</td>
                    <td>{{$user->ticket_stripes_activity}}</td>
                    <td>{{$user->role}}</td>
                    <td><a class="btn btn-warning" href="/accounts/{{$user->id}}/edit">Edit</a></td>
                    <td>
                        {!!Form::open(['action' => ['AccountsController@destroy', $user->id], 'method' => 'POST'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                        {!!Form::close()!!}
                    </td>
                </tr>
            @endforeach
        </table>
        @endif
    </div>
</div>

@endsection