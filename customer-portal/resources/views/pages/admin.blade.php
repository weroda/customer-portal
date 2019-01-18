@extends('layouts.app')

@section('content')

{{-- Alerts --}}
@if (session('status'))
<div class="card">
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
</div>
@endif

<h1>Admin dashboard</h1>

{{-- Users --}}
@if(count($users) > 0)
<div class="card">
    <div class="card-content">
        <h3>Accounts</h3>
        <table class="table">
            <tr>
                <th>Name</th>
                <th class="text-right">#ID</th>
                <th class="text-right">Email</th>
                <th class="text-right">Hours</th>
                <th class="text-right">Card activity</th>
                <th class="text-right">Role</th>
                <th class="text-right">Edit</th>
                <th class="text-right">Delete</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td class="text-right">#{{$user->id}}</td>
                    <td class="text-right">{{$user->email}}</td>
                    <td class="text-right">{{$user->ticket_stripes}}</td>
                    <td class="text-right">{{$user->ticket_stripes_activity}}</td>
                    <td class="text-right">{{$user->role}}</td>
                    <td class="text-right"><a class="btn btn-warning" href="/accounts/{{$user->id}}/edit">Edit</a></td>
                    <td class="text-right">
                        {!!Form::open(['action' => ['AccountsController@destroy', $user->id], 'method' => 'POST'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                        {!!Form::close()!!}
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $users->render() }}
    </div>
</div>
@endif

{{-- Open tickets --}}
@if(count($openTickets) > 0)
    <div class="card">
        <div class="card-content">
            <h3>Tickets: open</h3>
            <table class="table">
                <tr>
                    <th style="width: 20rem;">Ticket</th>
                    <th class="text-right">#ID</th>
                    <th class="text-right">View</th>
                    <th class="text-right">Edit</th>
                    <th class="text-right">Delete</th>
                </tr>
                @foreach ($openTickets as $ticket)
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
                        <td class="text-right">#{{$ticket->id}}</td>
                    <td class="text-right"><a class="btn btn-primary" href="/tickets/{{$ticket->id}}">View</a></td>
                        <td class="text-right"><a class="btn btn-warning {{$active}}" href="/tickets/{{$ticket->id}}/edit">Edit</a></td>
                        <td class="text-right">
                            {!!Form::open(['action' => ['TicketsController@destroy', $ticket->id], 'method' => 'POST'])!!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Delete', ['class' => 'btn btn-danger ' . $active])}}
                            {!!Form::close()!!}
                        </td>
                    </tr>
                @endforeach
            </table>
            {{$openTickets->render()}}
        </div>
    </div>
@else
    <p>No open tickets. Feels good.</p>
@endif  

{{-- Closed tickets --}}
@if(count($closedTickets) > 0)
<div class="card">
    <div class="card-content">
        <h3>Tickets: closed</h3>
            <table class="table">
                <tr>
                    <th style="width: 20rem;">Ticket</th>
                    <th class="text-right">#ID</th>
                    <th class="text-right">View</th>
                    <th class="text-right">Edit</th>
                    <th class="text-right">Delete</th>
                </tr>
                @foreach ($closedTickets as $ticket)
                    <tr>
                        <td>
                            {{$ticket->title}} <br>
                            @if($message !== '')
                                <span class="ticket-closed">{{$message}}</span>
                            @endif
                        </td>
                        <td class="text-right">#{{$ticket->id}}</td>
                    <td class="text-right"><a class="btn btn-primary" href="/tickets/{{$ticket->id}}">View</a></td>
                        <td class="text-right"><a class="btn btn-warning" href="/tickets/{{$ticket->id}}/edit">Edit</a></td>
                        <td class="text-right">
                            {!!Form::open(['action' => ['TicketsController@destroy', $ticket->id], 'method' => 'POST'])!!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                            {!!Form::close()!!}
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $closedTickets->render() }}
    </div>
</div>
@else
    <p>No closed tickets. Feels good.</p>
@endif

@endsection