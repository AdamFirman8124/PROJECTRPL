@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-8 text-center">
            <h1 class="display-4">Selamat Datang Para Gamer!</h1>
            <p class="lead mt-3">Bergabunglah dengan kami dalam petualangan epik melintasi dunia game yang tak terbatas.</p>
            <hr class="my-4">
            <p>Siap untuk memulai perjalanan Anda? Jelajahi, bermain, dan menangkan!</p>
            <a class="btn btn-primary btn-lg" href="{{ route('game') }}" role="button">Lihat Paket Game</a>
        </div>
    </div>
</div>

<footer style="text-align: center; padding: 20px; background-color: black; color: white;">
    <p>&copy; {{ date('Y') }} PlayPal Games. Semua hak cipta dilindungi (TAPI BOONG).</p>
    <p>Ikuti kami di <a href="https://twitter.com/playpal" style="color: #1DA1F2;">Twitter</a> dan <a href="https://facebook.com/playpal" style="color: #4267B2;">Facebook</a>!</p>
</footer>
@endsection
