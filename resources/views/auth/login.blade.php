<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .custom-dark {
            background-color: #333; /* Warna hitam yang lebih terang dari hitam pekat */
            color: #fff; /* Warna teks putih */
        }
        .is-invalid {
            border-color: #dc3545; /* Warna merah untuk border jika ada kesalahan */
        }
    </style>
</head>

<body class="bg-dark text-white">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="vh-100 d-flex align-items-center justify-content-center">
                <div class="card custom-dark p-4"> <!-- Tambahkan p-5 untuk padding lebih besar -->
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Log In to Your Account</h4>
                        
                        <!-- Tampilkan pesan peringatan jika ada -->
                        @if(session('warning'))
                            <div class="alert alert-warning">
                                {{ session('warning') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Log In</button>
                            </div>
                            <p class="mt-3 text-center">
                                Don't have an account? <a href="{{ route('register') }}" class="text-light">Sign up here</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

