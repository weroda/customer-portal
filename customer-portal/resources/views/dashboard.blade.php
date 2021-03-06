<?php 
use App\Ticket;
use App\Invoice; ?>


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

            {{-- Hours on card --}}
            <div class="card">
                <div class="card-body">
                    <h3>Hours on card: {{Auth::user()->ticket_stripes}}</h3>
                    <p>Hours will be written off when we processes your tickets.</p>
                    <p>
                        Your card is currently <b>{{Auth::user()->ticket_stripes_activity}}</b><br/>
                        <small>Want to freeze your hours? <a href="/dashboard/toggle-card">Toggle activity</a></small>
                    </p>
                </div>
            </div>
            

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
            
            {{-- Existing tickets --}}
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
                                @if(auth()->user()->id == $ticket->user_id)
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
                                @endif
                            @endforeach
                        </table>
                    @else
                        <p>You have no tickets or too many filters active.</p>
                    @endif
                </div>
            </div>

            {{-- Invoices --}}
            <div class="card">
                <div class="card-body">
                    <h3>Your invoices</h3>

                    <span class="sub-header">Filter invoices on status:</span>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Filter invoices
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="/">Show all</a>
                            <a class="dropdown-item" href="/dashboard/invoice-filter/paid">Show paid</a>
                            <a class="dropdown-item" href="/dashboard/invoice-filter/not-paid">Show not paid</a>
                        </div>
                    </div>

                    @if($invoices)
                        @if(count($invoices) > 0)
                            <table class="table">
                                <tr>
                                    <th>Invoice</th>
                                    <th>Status</th>
                                    <th>#ID</th>
                                    <th class="text-right">Download</th>
                                </tr>
                                @foreach ($invoices as $invoice)
                                    @if(auth()->user()->id == $invoice->user_id)
                                        <?php if($invoice->invoice_paid === 0) { $invoicePaid = "Not Paid"; } else { $invoicePaid = "Paid"; } ?>
                                        <tr>
                                            <td>{{$invoice->title}}</td>
                                            <td>{{$invoicePaid}}</td>
                                            <td>#{{$invoice->id}}</td>
                                            <td class="text-right"><a target="_blank" class="btn btn-primary" href="/storage/attachment_images/{{$invoice->pdf}}">Download</a></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        @else
                            <p>You have no invoices</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
