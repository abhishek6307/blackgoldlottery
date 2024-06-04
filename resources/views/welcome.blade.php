@extends('layouts.app')
@include('layouts.navbar')
@section('title', 'Welcome to Black Gold Lottery')

@section('content')
<style>
    .banner {
        background: url('{{ asset('images/banner5.webp') }}') no-repeat center center;
        background-size: cover;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        position: relative;
    }
</style>

<div class="banner">
    <div class="overlay"></div>
    <div class="form-container">
        <div class="lottery-ticket">
            <h1>Lottery Ticket</h1>
            <p>Draw Date: 2024-06-01</p>
            @if($undrawnLottery)
                <div class="mt-0">
                    <div id="timer">Time remaining: <span class="remaining-times" id="time">{{ gmdate('i:s', $timeRemaining) }}</span></div>
                </div>
            @endif
            <div id="numbers" class="numbers">
                <div class="number"></div>
            </div>
            <div class="serial">Serial Number: 123456789</div>
        </div>
        <form id="lottery-form" method="POST" action="{{ route('lottery.payment') }}">
            @csrf
            <input type="number" id="ticketCount" name="number" value="1" min="1" max="5" onchange="updateNumbersAndPrice()" />
            @auth
                <button type="submit" class="btn btn-primary btn-block">Buy Ticket</button>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-block">Buy Ticket</a>
            @endauth
        </form>
        <div id="price" class="mt-3">Price: ₹<span id="ticketPrice">11</span></div>
        <div id="response" class="mt-3"></div>
    </div>
</div>

@include('layouts.footer')
@endsection
