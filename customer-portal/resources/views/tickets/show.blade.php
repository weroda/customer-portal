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

    <h3>Comments</h3>
    @forelse ($ticket->comments as $comment)
        <div class="card ticket-wrap">
            <div class="card-content">
                <p>{{ $comment->user->name }} {{$comment->created_at}}</p>
                <p>{{ $comment->body }}</p>
                @if($comment->user->role == 1)
                    <span class="ticket_stripes_removed">Time spent: {{ $comment->ticket_stripes_removed }}</span>
                @endif
            </div>
        </div>
        @empty
        <p>This post has no comments</p>
    @endforelse

    <h3>New comment</h3>
    @if (Auth::check())
        {{ Form::open(['route' => ['comments.store'], 'method' => 'POST']) }}
        {{-- {{ Form::textarea('body', old('body'))}} --}}
        {{ Form::label('body', 'Comment content')}}
        {{ Form::textarea('body', '', ['class' => 'form-control', 'placeholder' => 'Ticket information'])}}
        @if(auth()->user()->role == 1)
            {{ Form::label('ticket_stripes_removed', 'Time spent')}}
            {{ Form::text('ticket_stripes_removed', '0', ['class' => 'form-control'])}}
        @endif
        {{ Form::hidden('ticket_id', $ticket->id) }}

        <br>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {{ Form::close() }}
    @endif  
        
        @if(!Auth::guest())
            @if(Auth::user()->id == $ticket->user_id)
                <a class="btn btn-warning" href="/tickets/{{$ticket->id}}/edit">Edit this ticket</a>
            @endif
        @endif

@endsection 