@extends('layouts.app')

@section('title', 'Lottery Draws')

@section('content')
<div class="container">
    <h1>Recent Lottery Draws</h1>
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <ul class="list-group">
        @foreach($draws as $draw)
            <li class="list-group-item">
                Draw at {{ $draw->draw_time }}: Winning Number - {{ $draw->winning_number }}
            </li>
        @endforeach
    </ul>
</div>
@endsection
