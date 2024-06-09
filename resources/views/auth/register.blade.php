<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">
    <div class="container">
        <div class="row justify-content-center custom-margin">
            <div class="col-md-6 mx-auto"> <!-- Tambahkan mx-auto untuk margin horizontal otomatis -->
                <div class="card custom-dark p-4"> <!-- Tambahkan p-4 untuk padding lebih besar -->

                    <div class="card-body">
                        <form class="form p-3" method="POST" action="{{ route('register') }}" onsubmit="return validateSecretCode()">
                            @csrf
                            <h5 class="card-title text-center mb-4">Register</h5>
                            <p class="card-text text-center mb-4">Signup now and get full access to our app.</p>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">{{ __('Role') }}</label>
                                <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" onchange="toggleSecretCodeInput()">
                                    <option value="customer">{{ __('Customer') }}</option>
                                    <option value="admin">{{ __('Admin') }}</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div id="secretCode" class="mb-3 hidden">
                                <label for="secret_code" class="form-label">{{ __('Secret Code') }}</label>
                                <input type="text" id="secret_code" class="form-control @error('secret_code') is-invalid @enderror" name="secret_code" placeholder="{{ __('Secret Code') }}">
                                @error('secret_code')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">{{ __('Register') }}</button>
                            <p class="mt-3 text-center">{{ __('Already have an account?') }} <a href="/login">{{ __('Sign in') }}</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

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

<style>
    .custom-dark {
        background-color: #333; /* Contoh warna hitam yang lebih terang dari hitam penuh */
        color: #fff; /* Warna teks putih */
    }

    .custom-margin {
        margin-top: 50px; /* Atur sesuai kebutuhan */
        margin-bottom: 50px; /* Atur sesuai kebutuhan */
    }
</style>