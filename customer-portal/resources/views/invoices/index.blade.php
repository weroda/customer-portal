@extends('layouts.app')

@section('content')
    <h1>Invoices</h1>

    @if(count($invoices) > 0)
        @foreach ($invoices as $invoice)
            <a href="/invoices/{{$invoice->id}}">
                <div class="card card-body">
                    <h3>{{$invoice->title}}</h3>
                    <small>Created at: {{$invoice->created_at}}</small>
                </div>
            </a>
        @endforeach
        
        {{-- pagination --}}
        {{$invoices->links()}}
        
    @else
        <p>No invoices</p>
    @endif

@endsection 