@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <h1>Dashboard</h1>
        
            {{-- Alerts --}}
            @if (session('status'))
                <div class="card">
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                </div>
            @endif
            

            {{-- Create new ticket --}}
            <div class="card">
                <div class="card-body">
                    <h3>Create ticket</h3>
                    <p>
                        Idea for an update? Problem with your current website? <em>Get in touch with a ticket.</em>
                    </p>
                    <a class="btn btn-primary" href="/tickets/create">Create ticket</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3>Your tickets</h3>

                    <span class="sub-header">Filter tickets on status:</span>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Filter tickets
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="/">Show all</a>
                            <a class="dropdown-item" href="/dashboard/open">Show open</a>
                            <a class="dropdown-item" href="/dashboard/closed">Show closed</a>
                        </div>
                    </div>

                    <span class="sub-header">Filter tickets with text:</span>
                    {!!Form::open(['action' => ['DashboardController@index'], 'method' => 'POST'])!!}
                        {{Form::text('query', '', ['class' => 'form-control'])}}
                        {{Form::submit('Enter text', ['class' => 'btn btn-light'])}}
                    {!!Form::close()!!}

                    @if(count($tickets) > 0)
                        <table class="table">
                            <tr>
                                <th>Ticket</th>
                                <th>#ID</th>
                                <th>View</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            @foreach ($tickets as $ticket)
                                <?php
                                    $message = '';
                                    $active = '';
                                    if($ticket->activity == 0) {
                                        $active = 'disabled';
                                        $message = 'CLOSED';
                                    }
                                ?>
                                <tr>
                                    <td>
                                        {{$ticket->title}} <br>
                                        @if($message !== '')
                                            <span class="ticket-closed">{{$message}}</span>
                                        @endif
                                    </td>
                                    <td>#{{$ticket->id}}</td>
                                <td><a class="btn btn-primary" href="/tickets/{{$ticket->id}}">View</a></td>
                                    <td><a class="btn btn-warning {{$active}}" href="/tickets/{{$ticket->id}}/edit">Edit</a></td>
                                    <td>
                                        {!!Form::open(['action' => ['TicketsController@destroy', $ticket->id], 'method' => 'POST'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger ' . $active])}}
                                        {!!Form::close()!!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>You have no tickets or too many filters active.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
