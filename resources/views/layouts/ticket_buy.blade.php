<style>
    .banner {
        background: url('{{ asset('images/banner5.webp') }}') no-repeat center center;
        background-size: cover;
        height: 115vh;
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

            <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="ticketPrice" name="ticketPrice" onchange="updateNumbersAndPrice()" required>
                <!-- <option value="" selected disabled>SELECT PRICE</option> -->
                <option value="11">₹11</option>
                <option value="21">₹21</option>
                <option value="51">₹51</option>
                <option value="101">₹101</option>
            </select>

            <input type="number" id="ticketCount" name="number" value="1" min="1" max="5" onchange="updateNumbersAndPrice()" />
            @auth
                <button type="submit" class="btn btn-primary btn-block">Buy Ticket</button>
                <div id="price" class="mt-1">Choose Quantity </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-block">Buy Ticket</a>
            @endauth
        </form>
        <div id="price" class="mt-3">Price: ₹<span id="totalPrice">11</span></div>
        <div class="buyied-tickets" class="mt-3">Tickets Sold <span class="green-color"><td class="align-middle">
                        <div class="progress-wrapper w-75 mx-auto">
                          <div class="progress-info">
                            <div class="progress-percentage">
                              <span class="text-xs font-weight-bold">{{$activeLotteryTicketsCounts}}%</span>
                            </div>
                          </div>
                          <div class="progress mt-3">
                          <div class="progress-bar bg-gradient-info" style="width: {{$activeLotteryTicketsCounts}}%;" role="progressbar" aria-valuenow="{{ $activeLotteryTicketsCounts }}" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </td></span></div>
        <div id="winningAmount" class="mt-3">Winning Amount: ₹<span id="winningPrice">100</span></div>
        <div id="response" class="mt-3"></div>
    </div>
</div>

<script>
const pricePerTicket = 11;
const winningMultiplier = 10;

function updateNumbersAndPrice() {
    const priceElement = document.getElementById('ticketPrice');
    const price = parseInt(priceElement.value);
    const quantityElement = document.getElementById('ticketCount');
    const quantity = parseInt(quantityElement.value);
    const totalPrice = price * quantity;

    document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
    document.getElementById('winningPrice').textContent = (totalPrice * 10);
    
    const numbersContainer = document.getElementById('numbers');
    numbersContainer.innerHTML = ''; // Clear existing circles
    for (let i = 0; i < quantity; i++) {
        numbersContainer.innerHTML += '<div class="number"></div>'; // Add new circles based on quantity
    }
}
</script>
