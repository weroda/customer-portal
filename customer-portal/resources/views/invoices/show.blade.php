@extends('layouts.app')

@section('content')

    <a class="btn btn-primary" role="button" href="/dashboard">Go back</a>
    
    <h1>{{$invoice->title}}</h1>

    <p>{!!$invoice->body!!}</p>

    <hr>

    <small>Written on: {{$invoice->created_at}}</small>

    <hr>

    <h2>Attachments</h2>

    @if($invoice->pdf !== '')
        <span class="attachmentImageTitle">View invoice:</span>
        <img src="/storage/attachment_images/{{$invoice->pdf}}" alt="">
    @endif

    @if(!Auth::guest())
        @if(Auth::user()->id == $invoice->user_id)
            <a class="btn btn-primary" href="/invoices/{{$invoice->id}}/edit">Edit</a>
            
            {!!Form::open(['action' => ['InvoicesController@destroy', $invoice->id], 'method' => 'POST'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
        @endif
    @endif

@endsection 