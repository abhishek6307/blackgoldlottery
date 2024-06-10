<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-flex align-items-center justify-content-around">
   <div>
    <a class="navbar-brand" href="/">
            <img src="{{ asset('images/logo_2.png') }}" width="30" height="30" class="d-inline-block align-top" alt="Black Gold Lottery Logo">
        </a>
   </div>
    <div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/buy-tickets">Buy Tickets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/about-us">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/contact-us">Contact Us</a>
            </li>
            <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            More
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('about') }}">About Us</a>
                            <a class="dropdown-item" href="{{ route('contact') }}">Contact Us</a>
                            <a class="dropdown-item" href="{{ route('pricing') }}">Pricing</a>
                            <a class="dropdown-item" href="{{ route('privacy') }}">Privacy Policy</a>
                            <a class="dropdown-item" href="{{ route('terms') }}">Terms & Conditions</a>
                            <a class="dropdown-item" href="{{ route('cancellation') }}">Cancellation/Refund Policy</a>
                        </div>
                    </li>
            
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Signup</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </div>
    </div>
</nav>
