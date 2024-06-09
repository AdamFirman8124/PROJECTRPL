<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playpal: Internet Cafe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/home/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/playpal-logo.png') }}" type="image/png">
</head>
<body style="background-color: black; color: white;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent custom-navbar">
        <a class="navbar-brand ml-5" href="{{ route('welcome') }}">
            <img src="{{ asset('images/playpal-logo.png') }}" alt="Logo" width="70" height="70" style="margin-right: 10px;">
            PLAYPAL
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav centered-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                @if(auth()->check() && auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('available.orders') }}">
                            Available Orders
                            @if(isset($newOrdersCount) && $newOrdersCount > 0)
                                <span class="badge badge-danger">{{ $newOrdersCount }}</span>
                            @endif
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('game') }}">Game Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cafe') }}">Cafe Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('checkout') }}">Checkout
                        @if(isset($checkoutItemCount) && $checkoutItemCount > 0)
                            <span class="badge badge-danger">{{ $checkoutItemCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>
        </div>
        <span class="navbar-text d-flex align-items-center">
            @if(auth()->check())
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle mr-2" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.758 1.226 5.468 2.37A7 7 0 0 0 8 1z"/>
                </svg>
                <a class="btn custom-btn" style="font-size: 20px;">{{ auth()->user()->name }}</a>
                <a class="btn custom-btn" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="float: left; margin-right: 30px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 3H5C3.897 3 3 3.897 3 5v14c0 1.103.897 2 2 2h5v-2H5V5h5V3zm10.707 8.293-4-4-1.414 1.414L17.586 11H9v2h8.586l-2.293 2.293 1.414 1.414 4-4a.999.999 0 0 0 0-1.414z"/>
                    </svg>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a class="btn" href="/login">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 0-1 0v3a1.5 1.5 0 0 0 1.5 1.5h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v3a.5.5 0 0 0 1 0v-3z"/>
                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793L8.146 10.646l.708.708 3-3z"/>
                    </svg>
                    Login
                </a>
                <a class="btn" href="/register">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5v2.5h2.5a.5.5 0 0 1 0 1H14v2.5a.5.5 0 0 1-1 0V9h-2.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                    </svg>
                    Register
                </a>
            @endif
        </span>
    </nav>
    <div id="app">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

