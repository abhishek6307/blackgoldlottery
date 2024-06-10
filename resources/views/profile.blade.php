@extends('layouts.app')
@include('layouts.navbar')
@section('title', 'Profile')

@section('content')<h1 style="text-align:center;">Profile Page</h1>


<div class="main-content position-relative max-height-vh-100 h-100">

    <div class="container-fluid px-2 px-md-4">
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <span class="mask  bg-gradient-primary  opacity-6"></span>
        </div>
        <div class="card card-body mx-3 mx-md-4 mt-n6">
            <div class="row gx-4 mb-2">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ asset('img/bruce-mars.jpg') }}" alt="profile_image"
                            class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            Richard Davis
                        </h5>
                        <p class="mb-0 font-weight-normal text-sm">
                            CEO / Co-Founder
                        </p>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="row">

                    <div class="col-12 col-xl-4">
                        <div class="card card-plain">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-md-8 d-flex align-items-center">
                                        <h6 class="mb-0">Profile Information</h6>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <a href="javascript:;">
                                            <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Edit Profile"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <p class="text-sm">

                                </p>
                                <hr class="horizontal gray-light my-4">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong
                                            class="text-dark">Full Name:</strong> &nbsp; {{ Auth::user()->name }}!</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong
                                            class="text-dark">Mobile:</strong> &nbsp; </li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong
                                            class="text-dark">Email:</strong> &nbsp; {{ Auth::user()->email }}</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong
                                            class="text-dark">Location:</strong> &nbsp; USA</li>
                                </ul>
                            </div>
                        </div>
                        <div class="card card-plain">
                            <div class="col-12 mb-4 today-winner-frontend">

                                <div class="card-header pb-0">
                                    <h6>Today's Winners : {{$winnersCountToday}}</h6>
                                    <!-- <p class="text-sm">
                    <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                    <span class="font-weight-bold">24%</span> this month
                  </p> -->
                                </div>
                                <div class="card-body p-3 mt-4">
                                    <div class="timeline timeline-one-side">
                                        @php
                                        $winnersCount = $winnersCountToday;
                                        @endphp
                                        @foreach($winnersToday as $winner)

                                        @if($winnersCount > 0)
                                        <div class="timeline-block mb-3">
                                            <span class="timeline-step">
                                                {{$winnersCount}}
                                                @php
                                                $winnersCount = $winnersCountToday - 1;
                                                @endphp
                                            </span>
                                            <div class="timeline-content">
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Name :
                                                    {{$winner->winner_name}}</h6>
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Winning Amount :
                                                    {{$winner->winning_amount}}</h6>
                                                <h6 class="text-dark text-sm font-weight-bold mb-0">Winning Number :
                                                    {{$winner->winner_number}}</h6>
                                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                    {{$winner->created_at->format('d M h:i A')}}
                                                </p>
                                            </div>
                                        </div>
                                        @endif

                                        @endforeach
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="col-12 col-xl-8">
                        <div class=" ">
                            <div style="padding:1rem 0 !important;" class="card-header" id="profile-tickets-section">
                                <div class="banner">
                                    <div class="form-container">
                                        <div class="lottery-ticket">
                                            <h1>Lottery Ticket</h1>
                                            <p>Draw Date: 2024-06-01</p>
                                            @if($undrawnLottery)
                                            <div class="mt-0">
                                                <div id="timer">Time remaining: <span class="remaining-times"
                                                        id="time">{{ gmdate('i:s', $timeRemaining) }}</span></div>
                                            </div>
                                            @endif
                                            <div id="numbers" class="numbers">
                                                <div class="number"></div>
                                            </div>
                                            <div class="serial">Serial Number: 123456789</div>
                                        </div>
                                        <form id="lottery-form" method="POST" action="{{ route('lottery.payment') }}">
                                            @csrf
                                            <select class="form-select form-select-sm"
                                                aria-label=".form-select-sm example" id="ticketPrice" name="ticketPrice"
                                                onchange="updateNumbersAndPrice()" required>
                                                <option value="" selected disabled>SELECT PRICE</option>
                                                <option value="11">₹11</option>
                                                <option value="21">₹21</option>
                                                <option value="51">₹51</option>
                                                <option value="101">₹101</option>
                                            </select>
                                            <input autocomplete="off" type="number" id="ticketCount" name="number"
                                                value="1" min="1" max="5" onchange="updateNumbersAndPrice()" />
                                            @auth
                                            <button type="submit" class="btn btn-primary btn-block">Buy Ticket</button>
                                            @else
                                            <a href="{{ route('login') }}" class="btn btn-primary btn-block">Buy
                                                Ticket</a>
                                            @endauth
                                        </form>
                                        <div id="price" class="mt-3">Price: ₹<span id="totalPrice">11</span></div>
                                        <div class="buyied-tickets" class="mt-3">Tickets Sold <span class="green-color">
                                                <td class="align-middle">
                                                    <div class="progress-wrapper w-75 mx-auto">
                                                        <div class="progress-info">
                                                            <div class="progress-percentage">
                                                                <span
                                                                    class="text-xs font-weight-bold">{{$activeLotteryTicketsCounts}}%</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress mt-3">
                                                            <div class="progress-bar bg-gradient-info"
                                                                style="width: {{$activeLotteryTicketsCounts}}%;"
                                                                role="progressbar"
                                                                aria-valuenow="{{ $activeLotteryTicketsCounts }}"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </span></div>
                                        <div id="winningAmount" class="mt-3">Winning Amount: ₹<span
                                                id="winningPrice"></span></div>
                                        <div id="response" class="mt-3"></div>
                                    </div>
                                </div>

                                <script>
                                    const winningMultiplier = 10;

                                    function updateNumbersAndPrice() {
                                        const priceElement = document.getElementById('ticketPrice');
                                        const price = parseInt(priceElement.value);
                                        const quantityElement = document.getElementById('ticketCount');
                                        const quantity = parseInt(quantityElement.value);
                                        const totalPrice = price * quantity;

                                        document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
                                        document.getElementById('winningPrice').textContent = (((price - 1) * quantity) * 10);

                                        const numbersContainer = document.getElementById('numbers');
                                        numbersContainer.innerHTML = '';
                                        for (let i = 0; i < quantity; i++) {
                                            numbersContainer.innerHTML += '<div class="number"></div>';
                                        }
                                    }

                                    // Timer logic
                                    let timeRemaining = {{ $timeRemaining }};
                                    const timerElements = document.getElementsByClassName('remaining-times');

                                    function updateTimer() {
                                        if (timeRemaining <= 0) {
                                            for (let i = 0; i < timerElements.length; i++) {
                                                timerElements[i].textContent = "00:00";
                                            }
                                            clearInterval(timerInterval);

                                            setTimeout(function () {
                                                location.reload();
                                            }, 2000);

                                            return;
                                        }
                                        timeRemaining -= 1;
                                        const minutes = Math.floor(timeRemaining / 60);
                                        const seconds = timeRemaining % 60;
                                        for (let i = 0; i < timerElements.length; i++) {
                                            timerElements[i].textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                                        }
                                    }

                                    const timerInterval = setInterval(updateTimer, 1000);
                                </script>

                                <div class="card-body p-3">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="mb-5 ps-3">
                            @if($tickets->isEmpty())
                            <h3>You have no tickets.</p>
                                @else
                                <h3 class="mb-1">Recent Tickets</h6>
                                    <p class="text-sm">Your Recent Tickets will appear here !</p>
                        </div>
                        <div class="row">


                            @foreach($tickets as $ticket)
                            <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                                <div class="card card-blog card-plain">
                                    <div class="card-header p-0 mt-n4 mx-3 sm-ticket-prof-show">
                                        <div class="lottery-ticket">
                                            <img src="{{ asset('images/logo_2.png') }}" width="95" height="95" alt=""
                                                class="ticket-image-prof">
                                            @php
                                            $isDrawn = $ticket->lottery->drawn;
                                            $quantity = $ticket->number;
                                            $win_num1 = $ticket->win_num1;
                                            $win_num2 = $ticket->win_num2;
                                            $win_num3 = $ticket->win_num3;
                                            $win_num4 = $ticket->win_num4;
                                            $win_num5 = $ticket->win_num5;
                                            $win_nums = array();

                                            if (!is_null($win_num1)) {
                                            $win_nums[] = $win_num1;
                                            }

                                            if (!is_null($win_num2)) {
                                            $win_nums[] = $win_num2;
                                            }

                                            if (!is_null($win_num3)) {
                                            $win_nums[] = $win_num3;
                                            }

                                            if (!is_null($win_num4)) {
                                            $win_nums[] = $win_num4;
                                            }

                                            if (!is_null($win_num5)) {
                                            $win_nums[] = $win_num5;
                                            }

                                            $drawTimePlus30 =
                                            \Carbon\Carbon::parse($ticket->lottery->created_at)->addMinutes(30);

                                            $user_won = 0;
                                            $winning_number = 0;
                                            foreach($win_nums as $win_num) {

                                            $winningDigits = str_split($winning_number);
                                            $ticketDigits = str_split($win_num);
                                            $matched = !empty(array_intersect($winningDigits, $ticketDigits));
                                            $winning_number = $ticket->lottery->winning_number;

                                            if($matched) {
                                            $user_won = 1;
                                            }

                                            }


                                            @endphp

                                            @if($isDrawn)
                                            <p>Drawn Date-Time: {{ $drawTimePlus30->format('d M h:i A') }}</p>
                                            <div class="mt-0">
                                                <div id="timer">Winner Number</div>
                                                <p style="font-size:12px;">Revealed !</p>
                                                <div class="numbers">
                                                    <div id="numbers" class="number" style="background-color: green;">
                                                        {{$ticket->lottery->winning_number}}</div>
                                                </div>
                                            </div>
                                            @else
                                            <p>Draw Date-Time:{{ $drawTimePlus30->format('d M h:i A') }}</p>
                                            <div class="mt-0">
                                                <div id="timer">Time remaining: <span class="remaining-times"
                                                        id="time">{{ gmdate('i:s', $timeRemaining) }}</span></div>
                                                <div id="timer">Winner Number</div>
                                                <p style="font-size:12px;">Not Revealed Yet !</p>
                                                <div class="numbers">
                                                    <div id="numbers" class="number"></div>
                                                </div>
                                            </div>
                                            @endif


                                            <div class="numbers">

                                                @php
                                                $winningDigits = str_split($winning_number);
                                                $firstMatchFound = false;
                                                @endphp

                                                @foreach($win_nums as $win_num)
                                                @php
                                                $ticketDigits = str_split($win_num);
                                                $matched = !empty(array_intersect($winningDigits, $ticketDigits));
                                                @endphp

                                                <div id="numbers" class="number"
                                                    style="{{ $matched && !$firstMatchFound ? 'background-color: green;' : '' }}">
                                                    {{ $win_num }}
                                                </div>

                                                @if ($matched && !$firstMatchFound)
                                                @php
                                                $firstMatchFound = true; // Set to true after the first match is found
                                                @endphp
                                                @endif
                                                @endforeach



                                            </div>

                                            <div class="serial">Serial Number: 123456789</div>
                                        </div>
                                    </div>
                                    <div class="card-body p-3 mt-3">
                                        <p class="mb-0 text-sm">Lootery ID : {{$ticket->lottery->id}}</p>
                                        <p class="mb-0 text-sm">Ticket ID : {{$ticket->id}}</p>
                                        @if($isDrawn)
                                        <h5>
                                            Ticket WIthdrawn
                                        </h5>
                                        @else
                                        <h5>
                                            Ticket Not WIthdrawn !
                                        </h5>
                                        @endif


                                        @if($user_won)
                                        <p class="mb-4 text-sm">Congratulation, You Won !</p>
                                        @else
                                        @if($isDrawn)
                                        <p class="mb-4 text-sm">Bad Luck !, Try Next Time!</p>
                                        @else
                                        <p class="mb-4 text-sm">You can we a Winner !</p>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif

                        </div>
                    </div>
                    @include('layouts.footer')
                </div>
            </div>
        </div>
    </div>
    <!-- @include('layouts.footer') -->
    <!-- <footer class="footer py-4  ">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
              © <script>
                document.write(new Date().getFullYear())
              </script>,
              made with <i class="fa fa-heart"></i> by
              <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
              for a better web.
            </div>
          </div>
          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer> -->
</div>
<div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="material-icons py-2">settings</i>
    </a>
    <div class="card shadow-lg">
        <div class="card-header pb-0 pt-3">
            <div class="float-start">
                <h5 class="mt-3 mb-0">Material UI Configurator</h5>
                <p>See our dashboard options.</p>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                    <i class="material-icons">clear</i>
                </button>
            </div>
            <!-- End Toggle Button -->
        </div>
        <hr class="horizontal dark my-1">
        <div class="card-body pt-sm-3 pt-0">
            <!-- Sidebar Backgrounds -->
            <div>
                <h6 class="mb-0">Sidebar Colors</h6>
            </div>
            <a href="javascript:void(0)" class="switch-trigger background-color">
                <div class="badge-colors my-2 text-start">
                    <span class="badge filter bg-gradient-primary active" data-color="primary"
                        onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-success" data-color="success"
                        onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-warning" data-color="warning"
                        onclick="sidebarColor(this)"></span>
                    <span class="badge filter bg-gradient-danger" data-color="danger"
                        onclick="sidebarColor(this)"></span>
                </div>
            </a>
            <!-- Sidenav Type -->
            <div class="mt-3">
                <h6 class="mb-0">Sidenav Type</h6>
                <p class="text-sm">Choose between 2 different sidenav types.</p>
            </div>
            <div class="d-flex">
                <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark"
                    onclick="sidebarType(this)">Dark</button>
                <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent"
                    onclick="sidebarType(this)">Transparent</button>
                <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white"
                    onclick="sidebarType(this)">White</button>
            </div>
            <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
            <!-- Navbar Fixed -->
            <div class="mt-3 d-flex">
                <h6 class="mb-0">Navbar Fixed</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                        onclick="navbarFixed(this)">
                </div>
            </div>
            <hr class="horizontal dark my-3">
            <div class="mt-2 d-flex">
                <h6 class="mb-0">Light / Dark</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version"
                        onclick="darkMode(this)">
                </div>
            </div>
            <hr class="horizontal dark my-sm-4">
            <a class="btn bg-gradient-info w-100"
                href="https://www.creative-tim.com/product/material-dashboard-pro">Free Download</a>
            <a class="btn btn-outline-dark w-100"
                href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View
                documentation</a>
            <div class="w-100 text-center">
                <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard"
                    data-icon="octicon-star" data-size="large" data-show-count="true"
                    aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
                <h6 class="mt-3">Thank you for sharing!</h6>
                <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard"
                    class="btn btn-dark mb-0 me-2" target="_blank">
                    <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard"
                    class="btn btn-dark mb-0 me-2" target="_blank">
                    <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
                </a>
            </div>
        </div>
    </div>

</div>
@endsection