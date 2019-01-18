@extends('layouts.app')

@section('content')

    <p class="btn-top">
        @if(auth()->user()->role === 1)
            <a class="btn btn-light btn-top" role="button" href="/admin"><i class="fas fa-angle-left"></i> Return to admin dashboard</a>
        @else
            <a class="btn btn-light btn-top" role="button" href="/dashboard"><i class="fas fa-angle-left"></i> Return to dashboard</a>
        @endif
    </p>
    
    <h1>
        {{$ticket->title}}
        <hr>
        <p>Created at: {{$ticket->created_at->format('d-m-Y')}}</p>
    </h1>

    <div class="card ticket-wrap">
        <div class="card-content">
            <p><strong>Ticket content:</strong></p>
            <p>{!!$ticket->body!!}</p>
        
            <hr>
        
            @if($ticket->attachment_1 !== '' || $ticket->attachment_2 !== '' || $ticket->attachment_3 !== '')
                <p><strong>Ticket attachments:</strong></p>
        
                <div class="card-attachments-container">
                    @if($ticket->attachment_1 !== '')
                        <div class="card card-attachment-container" style="width: 18rem;">
                            <div class="card-content card-attachment">
                                <span class="attachmentImageTitle">Attachment 1:</span> <br>
                            <a href="/storage/attachment_images/{{$ticket->attachment_1}}">
                                <div class="attachment-image-div" style="background-image: url('/storage/attachment_images/{{$ticket->attachment_1}}')"></div>
                            </a>
                            </div>
                        </div>
                    @endif
            
                    @if($ticket->attachment_2 !== '')
                        <div class="card card-attachment-container" style="width: 18rem;">
                            <div class="card-content card-attachment">
                                <span class="attachmentImageTitle">Attachment 2:</span> <br>
                            <a href="/storage/attachment_images/{{$ticket->attachment_2}}">
                                <div class="attachment-image-div" style="background-image: url('/storage/attachment_images/{{$ticket->attachment_2}}')"></div>
                            </a>
                            </div>
                        </div>
                    @endif
            
                    @if($ticket->attachment_3 !== '')
                        <div class="card card-attachment-container" style="width: 18rem;">
                            <div class="card-content card-attachment">
                                <span class="attachmentImageTitle">Attachment 3:</span> <br>
                            <a href="/storage/attachment_images/{{$ticket->attachment_3}}">
                                <div class="attachment-image-div" style="background-image: url('/storage/attachment_images/{{$ticket->attachment_3}}')"></div>
                            </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
        
        @if(!Auth::guest())
            @if(Auth::user()->id == $ticket->user_id)
                <a class="btn btn-warning" href="/tickets/{{$ticket->id}}/edit">Edit this ticket</a>
            @endif
        @endif

@endsection 