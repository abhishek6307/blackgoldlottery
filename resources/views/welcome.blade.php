@extends('layouts.app')

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
                        <div id="timer">Time remaining: <span id="time">{{ gmdate('i:s', $timeRemaining) }}</span></div>

                    </div>
                @endif
                <div id="numbers" class="numbers">
                    <div class="number"></div>
                </div>
                <div class="serial">Serial Number: 123456789</div>
            </div>
        <form id="lottery-form">
            
                <input type="number" id="ticketCount" name="number" value="1" min="1" max="5" onchange="updateNumbers()" />
               

            <button type="submit" class="btn btn-primary btn-block">Buy Ticket</button>
        </form>
        
        
        
        <div id="response" class="mt-3"></div>
    </div>
</div>




<script>
    $(document).ready(function(){
        $('#lottery-form').on('submit', function(event){
            event.preventDefault();
            var number = $('#number').val();
            $.ajax({
                url: '/ticket',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    number: number
                },
                success: function(response){
                    $('#response').html('<p class="text-success">' + response.success + '</p>');
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    $('#response').html('<p class="text-danger">' + response.error + '</p>');
                }
            });
        });

        $('#withdraw-form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url: '{{ route('lottery.withdraw') }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    $('#lottery-id').text(response.newLottery.id);
                    $('#created-at').text(response.created_at);
                    $('#time').text('30:00');
                    timeRemaining = response.timeRemaining;
                    updateTimer();
                },
                error: function(xhr, status, error) {
                    var response = JSON.parse(xhr.responseText);
                    alert('Error: ' + response.error);
                }
            });
        });

        // Initialize the countdown timer
        var timeRemaining = {{ $timeRemaining }};
        function updateTimer() {
            var minutes = Math.floor(timeRemaining / 60);
            var seconds = timeRemaining % 60;
            var timeString = str_pad(minutes, 2, '0') + ':' + str_pad(seconds, 2, '0');
            $('#time').text(timeString);

            if (timeRemaining > 0) {
                timeRemaining -= 1;
                setTimeout(updateTimer, 1000);
            } else {
                $.ajax({
                    url: '{{ route('lottery.withdraw') }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response){
                        $('#lottery-id').text(response.newLottery.id);
                        $('#created-at').text(response.created_at);
                        $('#time').text('30:00');
                        timeRemaining = response.timeRemaining;
                        updateTimer();
                    },
                    error: function(xhr, status, error) {
                        var response = JSON.parse(xhr.responseText);
                        alert('Error: ' + response.error);
                    }
                });
            }
        }
        updateTimer();

        function str_pad(n, width, z) {
            z = z || '0';
            n = n + '';
            return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
        }
    });
    function updateNumbers() {
            const quantity = document.getElementById('ticketCount').value;
            const numbersContainer = document.getElementById('numbers');
            numbersContainer.innerHTML = ''; // Clear existing circles
            for (let i = 0; i < quantity; i++) {
                numbersContainer.innerHTML += '<div class="number"></div>'; // Add new circles based on quantity
            }
        }
</script>
@endsection
