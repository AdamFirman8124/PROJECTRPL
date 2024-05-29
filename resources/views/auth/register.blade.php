<style>
    body {
        background-color: black;
    }
    .form {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-width: 550px;
        background-color: #fff;
        padding: 20px;
        border-radius: 20px;
        position: relative;
    }

    .title {
        font-size: 28px;
        color: royalblue;
        font-weight: 600;
        letter-spacing: -1px;
        position: relative;
        display: flex;
        align-items: center;
        padding-left: 30px;
    }

    .title::before,.title::after {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        border-radius: 50%;
        left: 0px;
        background-color: royalblue;
    }

    .title::before {
        width: 18px;
        height: 18px;
        background-color: royalblue;
    }

    .title::after {
        width: 18px;
        height: 18px;
        animation: pulse 1s linear infinite;
    }

    .message, .signin {
        color: rgba(88, 87, 87, 0.822);
        font-size: 14px;
    }

    .signin {
        text-align: center;
    }

    .signin a {
        color: royalblue;
    }

    .signin a:hover {
        text-decoration: underline royalblue;
    }

    .flex {
        display: flex;
        width: 100%;
        gap: 6px;
    }

    .form label {
        position: relative;
    }

    .form label .input {
        width: 100%;
        padding: 10px 10px 20px 10px;
        outline: 0;
        border: 1px solid rgba(105, 105, 105, 0.397);
        border-radius: 10px;
    }

    .form label .input + span {
        position: absolute;
        left: 10px;
        top: 15px;
        color: grey;
        font-size: 0.9em;
        cursor: text;
        transition: 0.3s ease;
    }

    .form label .input:placeholder-shown + span {
        top: 15px;
        font-size: 0.9em;
    }

    .form label .input:focus + span,.form label .input:valid + span {
        top: 30px;
        font-size: 0.7em;
        font-weight: 600;
    }

    .form label .input:valid + span {
        color: green;
    }

    .submit {
        border: none;
        outline: none;
        background-color: royalblue;
        padding: 10px;
        border-radius: 10px;
        color: #fff;
        font-size: 16px;
        transform: .3s ease;
    }

    .submit:hover {
        background-color: rgb(56, 90, 194);
    }

    @keyframes pulse {
    from {
        transform: scale(0.9);
        opacity: 1;
    }

    to {
        transform: scale(1.8);
        opacity: 0;
    }
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card {
        width: 100%;
        max-width: 450px;
        border-radius: 20px; /* Membuat pinggir tidak lancip */
        box-shadow: 0 8px 16px rgba(128,128,128,0.5); /* Menambahkan bayangan berwarna abu-abu disekitar card dengan ukuran yang lebih besar */
    }

    #secretCode {
        display: none;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <form class="form" method="POST" action="{{ route('register') }}" onsubmit="return validateSecretCode()">
                        @csrf
                        <p class="title">Register</p>
                        <p class="message">Signup now and get full access to our app.</p>
                        
                        <div class="flex">
                            <label>
                                <input id="name" type="text" class="input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required placeholder="" autofocus>
                                <span>{{ __('Firstname') }}</span>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </label>

                            <label>
                                <input id="lastname" type="text" class="input @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required placeholder="">
                                <span>{{ __('Lastname') }}</span>
                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </label>
                        </div>

                        <label>
                            <input id="email" type="email" class="input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="">
                            <span>{{ __('Email') }}</span>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>

                        <label>
                            <input id="password" type="password" class="input @error('password') is-invalid @enderror" name="password" required placeholder="">
                            <span>{{ __('Password') }}</span>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>

                        <label>
                            <input id="password-confirm" type="password" class="input" name="password_confirmation" required placeholder="">
                            <span>{{ __('Confirm Password') }}</span>
                        </label>

                        <div class="flex" style="width: 100%;">
                            <label style="width: 100%;">
                                <select id="role" name="role" class="input @error('role') is-invalid @enderror" onchange="toggleSecretCodeInput()" style="width: 100%;">
                                    <option value="customer">{{ __('Customer') }}</option>
                                    <option value="admin">{{ __('Admin') }}</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </label>
                        </div>

                        <div id="secretCode" class="hidden">
                            <label class="full-width">
                                <input type="text" class="input full-width @error('secret_code') is-invalid @enderror" name="secret_code" placeholder="{{ __('Secret Code') }}">
                                @error('secret_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </label>
                        </div>

                        <button type="submit" class="submit">{{ __('Register') }}</button>
                        <p class="signin">{{ __('Already have an account?') }} <a href="/login">{{ __('Sign in') }}</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSecretCodeInput() {
    var roleSelect = document.getElementById('role');
    var secretCodeInput = document.getElementById('secretCode');
    if (roleSelect.value === 'admin') {
        secretCodeInput.style.display = 'block';
    } else {
        secretCodeInput.style.display = 'none';
    }
}

function validateSecretCode() {
    var roleSelect = document.getElementById('role');
    var secretCodeInput = document.getElementById('secret-code');
    if (roleSelect.value === 'admin' && secretCodeInput.value !== 'rahasia') {
        alert('Kode rahasia salah.');
        return false;
    }
    return true;
}

// Panggil fungsi ini saat halaman dimuat untuk memastikan semuanya disetel dengan benar
document.addEventListener('DOMContentLoaded', function() {
    toggleSecretCodeInput(); // Pastikan ini dipanggil saat halaman dimuat
});
</script>


