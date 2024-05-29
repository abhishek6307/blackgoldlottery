@extends('layouts.app')

@section('title', 'Recent Lotteries')

@section('content')
<div class="container">
    <h1>Recent Lotteries</h1>
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <ul class="list-group">
        @foreach($lotteries as $lottery)
            <li class="list-group-item">
                Lottery created at {{ $lottery->created_at }}: 
                @if($lottery->drawn)
                    Drawn at {{ $lottery->draw_time }} - Winning Number: {{ $lottery->winning_number }}
                @else
                    Not Drawn Yet
                @endif
            </li>
        @endforeach
    </ul>
</div>
@endsection
