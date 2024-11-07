@extends('layouts.app')

@section('title', 'Messages')

@section('content')
    <div class="container">
        <h1>Messages reçus</h1>

        <div class="messages-grid">
            @foreach($messages as $message)
                <div class="message-card">
                    <h3>{{ $message['subject'] }}</h3>
                    <p><strong>De:</strong> {{ $message['name'] }}</p>
                    <p><strong>Email:</strong> {{ $message['email'] }}</p>
                    <p><strong>Date:</strong> {{ $message['created_at'] }}</p>
                    <p><strong>Message:</strong> {{ $message['message'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection

