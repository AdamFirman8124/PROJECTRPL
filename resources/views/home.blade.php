<style>
    body {
        background-color: black;
    }

    .logout-button {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }
    
    .card {
        position: relative;
        width: 190px;
        height: 254px;
        background-color: #000;
        display: flex;
        flex-direction: column;
        justify-content: end;
        padding: 12px;
        gap: 12px;
        border-radius: 8px;
        cursor: pointer;
        margin-top: 35px;
    }
    
    .card::before {
        content: '';
        position: absolute;
        inset: 0;
        left: -5px;
        margin: auto;
        width: 200px;
        height: 264px;
        border-radius: 10px;
        background: linear-gradient(-45deg, #e81cff 0%, #40c9ff 100%);
        z-index: -10;
        pointer-events: none;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .card::after {
        content: "";
        z-index: -1;
        position: absolute;
        inset: 0;
        background: linear-gradient(-45deg, #fc00ff 0%, #00dbde 100%);
        transform: translate3d(0, 0, 0) scale(0.95);
        filter: blur(20px);
    }
    
    .heading {
        font-size: 20px;
        text-transform: capitalize;
        font-weight: 700;
    }
    
    .card p:not(.heading) {
        font-size: 14px;
    }
    
    .card p:last-child {
        color: #e81cff;
        font-weight: 600;
    }
    
    .card:hover::after {
        filter: blur(30px);
    }
    
    .card:hover::before {
        transform: rotate(-90deg) scaleX(1.34) scaleY(0.77);
    }
    
    .container-center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    
    .card1 {
        width: 210px;
        height: 150px;
        background: rgb(17, 4, 134);
        border-radius: 15px;
        box-shadow: rgb(0,0,0,0.7) 5px 10px 50px ,rgb(0,0,0,0.7) -5px 0px 250px;
        display: flex;
        color: white;
        justify-content: center;
        position: relative;
        flex-direction: column;
        background: linear-gradient(to right, rgb(20, 30, 48), rgb(36, 59, 85));
        cursor: pointer;
        transition: all 0.3s ease-in-out;
        overflow: hidden;
        margin-top: 30px;
    }

    .card:hover {
    box-shadow: rgb(0,0,0) 5px 10px 50px ,rgb(0,0,0) -5px 0px 250px;
    }

    .card-header {
        color: white;
        padding: 10px 15px;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }

    .time-text {
    font-size: 50px;
    margin-top: 20px;
    margin-left: 15px;
    font-weight: 600;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .time-sub-text {
    font-size: 15px;
    margin-left: 5px;
    }

    .day-text {
    font-size: 18px;
    margin-top: 0px;
    margin-left: 15px;
    font-weight: 500;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .moon {
    font-size: 20px;
    position: absolute;
    right: 15px;
    top: 15px;
    transition: all 0.3s ease-in-out;
    }

    .card:hover > .moon {
    font-size: 23px;
    }

    .logout-button button {
        background-color: red;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 10px;
    }

    .logout-button button:hover {
        background-color: #ff4747; /* Warna merah yang lebih terang saat di-hover */
        transform: scale(1.05); /* Meningkatkan ukuran sedikit */
        transition: transform 0.3s ease, background-color 0.3s ease; /* Menambahkan animasi untuk transformasi dan perubahan warna */
    }

    .logout-button button {
        transition: transform 0.3s ease, background-color 0.3s ease; /* Menambahkan animasi kembali saat mouse tidak lagi di atas tombol */
    }

    .btn-cart {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 10px;
        border: none;
        background-color: transparent;
        position: absolute;
        right: 20px;
        top: 10px;
    }

    .btn-cart::after {
        content: attr(data-quantity);
        width: fit-content;
        height: fit-content;
        position: absolute;
        font-size: 15px;
        color: white;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        opacity: 0;
        visibility: hidden;
        transition: .2s linear;
        top: 115%;
    }

    .icon-cart {
        width: 24.38px;
        height: 30.52px;
        transition: .2s linear;
    }

    .icon-cart path {
        fill: rgb(240, 8, 8);
        transition: .2s linear;
    }

    .btn-cart:hover > .icon-cart {
        transform: scale(1.2);
    }

    .btn-cart:hover > .icon-cart path {
        fill: rgb(186, 34, 233);
    }

    .btn-cart:hover::after {
        visibility: visible;
        opacity: 1;
        top: 105%;
    }

    .quantity {
        display: none;
    }

    .main-card {
        margin: auto;
        width: 30%; /* Atur lebar masing-masing kartu */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
    }

    .main-content {
        display: flex;
        justify-content: center;
        gap: 10px; /* Tambahkan gap antar kartu */
        width: 100%; /* Mengambil lebar penuh container */
        margin-top: 20px; /* Tambahkan margin atas jika perlu */
    }

    .container {
        display: flex;
        flex-direction: row; /* Mengatur konten secara horizontal */
    }

    .left-sidebar {
        width: 20%; /* Atur lebar sidebar */
        min-height: 100vh; /* Pastikan sidebar memiliki tinggi penuh */
        background-color: #f4f4f4; /* Beri background agar terlihat berbeda */
        padding: 20px; /* Tambahkan padding untuk memberikan ruang */
        background-color: #000;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<div class="container">
    <div class="left-sidebar">
        <div class="container-start" style="margin-left: 2%;">
            <div class="card" style="background-color: black; color: white;">
                <div class="card-header" style="font-size: 24px;">
                    {{ __('Selamat Datang, ') . Auth::user()->name . '!' }}
                </div>
                <div class="box" style="margin-left: 7%;">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>{{ __('Selamat, Kamu sudah login!') }}</p>

                    <div class="logout-button" style="margin-right: 7%;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">{{ __('Logout') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card1">
                <p class="time-text"><span id="live-time">00:00</span><span class="time-sub-text" id="am-pm">AM</span></p>
                <p class="day-text" id="live-date">Monday, January 1st</p>
            </div>
            <button data-quantity="0" class="btn-cart">
                <svg class="icon-cart" viewBox="0 0 24.38 30.52" height="30.52" width="24.38" xmlns="http://www.w3.org/2000/svg">
                    <title>icon-cart</title>
                    <path transform="translate(-3.62 -0.85)" d="M28,27.3,26.24,7.51a.75.75,0,0,0-.76-.69h-3.7a6,6,0,0,0-12,0H6.13a.76.76,0,0,0-.76.69L3.62,27.3v.07a4.29,4.29,0,0,0,4.52,4H23.48a4.29,4.29,0,0,0,4.52-4ZM15.81,2.37a4.47,4.47,0,0,1,4.46,4.45H11.35a4.47,4.47,0,0,1,4.46-4.45Zm7.67,27.48H8.13a2.79,2.79,0,0,1-3-2.45L6.83,8.34h3V11a.76.76,0,0,0,1.52,0V8.34h8.92V11a.76.76,0,0,0,1.52,0V8.34h3L26.48,27.4a2.79,2.79,0,0,1-3,2.44Zm0,0"></path>
                </svg>
                <span class="quantity"></span>
            </button>
        </div>
    </div>
    <div class="main-content">
        <div class="card2 main-card">
            <div class="card-header">Paket Warnet</div>
            <p>Pilih paket internet cepat untuk kebutuhan warnet Anda.</p>
        </div>
        <div class="card3 main-card">
            <div class="card-header">Paket Cafe</div>
            <p>Nikmati koneksi tanpa henti untuk pengunjung cafe Anda.</p>
        </div>
    </div>
</div>

<script>
    function updateLiveTime() {
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        const formattedHours = hours % 12 || 12;
        const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
        const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const day = dayNames[now.getDay()];
        const date = now.getDate();
        const month = monthNames[now.getMonth()];
        const year = now.getFullYear();
        const ordinal = date % 10 === 1 && date !== 11 ? 'st' : (date % 10 === 2 && date !== 12 ? 'nd' : (date % 10 === 3 && date !== 13 ? 'rd' : 'th'));

        document.getElementById('live-time').textContent = `${formattedHours}:${formattedMinutes}`;
        document.getElementById('am-pm').textContent = ampm;
        document.getElementById('live-date').textContent = `${day}, ${month} ${date}${ordinal}`;
    }
    setInterval(updateLiveTime, 1000);
    updateLiveTime();

    let logoutTimer;

    function resetLogoutTimer() {
        clearTimeout(logoutTimer);
        logoutTimer = setTimeout(() => {
            window.location.href = '/logout'; // Sesuaikan dengan URL logout Anda
        }, 60000); // 60000 ms = 1 menit
    }

    document.onload = resetLogoutTimer();
    document.onmousemove = resetLogoutTimer;
    document.onkeypress = resetLogoutTimer;
</script>
</div>
</div>

