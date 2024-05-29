<style>
    body{
        background-color: black;
    }
    .card {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 490px;
        height: 550px;
        border-radius: 14px;
        z-index: 1111;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 1px 1px 10px #ff0000, -1px -1px 10px #ff0000;
    }

    .bg {
        position: absolute;
        top: 5px;
        left: 5px;
        width: 480px;
        height: 540px;
        z-index: 2;
        background: rgba(0, 0, 0, .95);
        backdrop-filter: blur(24px);
        border-radius: 10px;
        overflow: hidden;
        outline: 2px black;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-evenly;
        font-size: 20px;
        text-align: center;
    }

    .blob {
        position: absolute;
        z-index: 1;
        top: 50%;
        left: 50%;
        width: 400px;
        height: 450px;
        border-radius: 50%;
        background-color: #ff0000;
        opacity: 1;
        filter: blur(12px);
        animation: blob-bounce 5s infinite ease;
    }

    @keyframes blob-bounce {
        0% {
            transform: translate(-100%, -100%) translate3d(0, 0, 0);
        }

        25% {
            transform: translate(-100%, -100%) translate3d(100%, 0, 0);
        }

        50% {
            transform: translate(-100%, -100%) translate3d(100%, 100%, 0);
        }

        75% {
            transform: translate(-100%, -100%) translate3d(0, 100%, 0);
        }

        100% {
            transform: translate(-100%, -100%) translate3d(0, 0, 0);
        }
    }

    .button {
        padding: 10px 20px;
        margin: 0 5px; /* Menambahkan margin untuk memberi jarak antar tombol */
        border: none;
        border-radius: 5px;
        background-color: #ff0000;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
    }

    .button:hover {
        background-color: #cc0000;
        transform: scale(1.1);
    }

    .button-container {
        display: flex;
        justify-content: center; /* Mengubah dari space-between menjadi center */
        width: 100%;
        padding: 0 20px;
        gap: 20px; /* Menambahkan gap untuk memberikan jarak antar tombol */
    }
</style>
<div class="card">
    <div class="bg">
        <p>Selamat datang di dunia kami!</p>
        <div class="button-container">
            <a href="/login" class="button">Login</a>
            <a href="/register" class="button">Register</a>
        </div>
    </div>
    <div class="blob"></div>
</div>


