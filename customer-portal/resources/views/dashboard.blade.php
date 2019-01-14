@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <a class="btn btn-primary" href="/tickets/create">Create ticket</a>
                    <h3>Your tickets</h3>

                    @if(count($tickets) > 0)
                        <table class="table">
                            <tr>
                                <th>Title</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{$ticket->title}}</td>
                                    <td><a class="btn btn-primary" href="/tickets/{{$ticket->id}}/edit">Edit</a></td>
                                    <td>
                                        {!!Form::open(['action' => ['TicketsController@destroy', $ticket->id], 'method' => 'POST'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close()!!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>You have no tickets</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
