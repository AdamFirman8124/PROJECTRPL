@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center align-items-center" style="height: 80vh;">
        <div class="col-md-8 text-center">
            <h1 class="display-4">Selamat Datang Para Gamer!</h1>
            <p class="lead mt-3">Bergabunglah dengan kami dalam petualangan epik melintasi dunia game yang tak terbatas.</p>
            <hr class="my-4">
            <p>Siap untuk memulai perjalanan Anda? Jelajahi, bermain, dan menangkan!</p>
            <a class="btn btn-primary btn-lg" href="{{ route('game') }}" role="button">Lihat Paket Game</a>
        </div>
    </div>
    <div class="row mt-5 align-items-center">
        <div class="col-md-8 text-center">
            <h2>Mengapa Memilih Warnet Kami?</h2>
            <p class="lead">Warnet kami menyediakan koneksi internet yang sangat cepat, suasana yang nyaman, serta perangkat gaming terkini yang akan meningkatkan kualitas bermain Anda. Kami juga menawarkan berbagai fasilitas pendukung untuk memastikan kenyamanan Anda saat bermain tanpa gangguan.</p>
        </div>
        <div class="col-md-4">
            <img src="{{ asset('images/Orange and Black Grunge Game Mobile Video.gif') }}" alt="Game Gif 1" class="img-fluid" style="max-width: 90%;">
        </div>
    </div>
    <div class="row mt-5" style="min-height: 100vh;">
        <div class="col-md-12">
            <h3 class="mb-5">Produk Warnet</h3>
            <div class="d-flex flex-row overflow-hidden position-relative row-hover">
                @if($warnetProducts->count() > 3)
                    <button class="btn btn-secondary position-absolute start-0 top-50 translate-middle-y scroll-btn" onclick="scrollLeftWarnet('warnetProducts')" style="z-index: 1;">&lt;</button>
                @endif
                <div id="warnetProducts" class="d-flex flex-row overflow-hidden" style="scroll-behavior: smooth;">
                    @foreach($warnetProducts as $product)
                        <div class="card mb-3 me-3" style="width: 420px; flex: 0 0 auto; pointer-events: none; border: none; box-shadow: 0 8px 16px rgba(128, 128, 128, 0.3);">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">Rp{{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($warnetProducts->count() > 3)
                    <button class="btn btn-secondary position-absolute end-0 top-50 translate-middle-y scroll-btn" onclick="scrollRightWarnet('warnetProducts')">&gt;</button>
                @endif
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <h3 class="mb-5">Produk Cafe</h3>
            <div class="d-flex flex-row overflow-hidden position-relative row-hover">
                @if($cafeProducts->count() > 3)
                    <button class="btn btn-secondary position-absolute start-0 top-50 translate-middle-y scroll-btn" onclick="scrollLeftCafe('cafeProducts')" style="z-index: 1;">&lt;</button>
                @endif
                <div id="cafeProducts" class="d-flex flex-row overflow-hidden" style="scroll-behavior: smooth;">
                    @foreach($cafeProducts as $product)
                        <div class="card mb-3 me-3" style="width: 420px; flex: 0 0 auto; pointer-events: none; border: none; box-shadow: 0 8px 16px rgba(128, 128, 128, 0.3);">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">Rp{{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($cafeProducts->count() > 3)
                    <button class="btn btn-secondary position-absolute end-0 top-50 translate-middle-y scroll-btn rounded-pill" onclick="scrollRightCafe('cafeProducts')">&gt;</button>
                @endif
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-3 bg-dark text-white">
    <p>&copy; {{ date('Y') }} PlayPal Games. Semua hak cipta dilindungi.</p>
    <p>Ikuti kami di <a href="https://twitter.com/playpal" class="text-primary">Twitter</a> dan <a href="https://facebook.com/playpal" class="text-primary">Facebook</a>!</p>
</footer>

<script>
    function scrollLeftWarnet(id) {
        document.getElementById(id).scrollBy({ left: -440, behavior: 'smooth' });
    }

    function scrollRightWarnet(id) {
        document.getElementById(id).scrollBy({ left: 440, behavior: 'smooth' });
    }

    function scrollLeftCafe(id) {
        document.getElementById(id).scrollBy({ left: -440, behavior: 'smooth' });
    }

    function scrollRightCafe(id) {
        document.getElementById(id).scrollBy({ left: 440, behavior: 'smooth' });
    }

    document.querySelectorAll('.row-hover').forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.querySelectorAll('.scroll-btn').forEach(btn => {
                btn.style.opacity = 1;
                btn.style.transition = 'opacity 0.3s';
            });
        });
        row.addEventListener('mouseleave', () => {
            row.querySelectorAll('.scroll-btn').forEach(btn => {
                btn.style.opacity = 0;
                btn.style.transition = 'opacity 0.3s';
            });
        });
    });
</script>
@endsection


