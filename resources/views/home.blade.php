<head>
    <title>Halaman Utama</title>
    <link rel="stylesheet" href="{{ asset('css/home/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendar/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/style.css') }}">
</head>

<body>
    <header>
        <h1>Header</h1>
    </header>
    <div class="content-wrapper">
        <aside>
            <div class="container-start">
                <div class="box">
                    <div class="content">
                        <h2>Selamat Datang, {{ Auth::user()->name }}!
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="logout-button" style="color: white; background-color: red">Logout</button>
                            </form>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="cardClock">
                <p class="time-text"><span id="time-now"></span><span class="time-sub-text" id="am-pm"></span></p>
                <p class="day-text" id="date-now"></p>
            </div>
            <div class="button-wrapper">
                <button id="addProductButton" class="btn btn-primary small-btn">Tambah Produk Warnet</button>
                <button id="addCafeProductButton" class="btn btn-primary small-btn">Tambah Produk Cafe</button>
            </div>
        </aside>
        <main>
            <div class="products-container">
                <div class="products-column">
                    <h2>Produk Warnet</h2>
                    @foreach($products as $product)
                        <div class="main-content">
                            <div class="main-title">{{ $product->name }}</div>
                            <div class="main-price">${{ $product->price }}</div>
                            <div class="main-description">{{ $product->description }}</div>
                            <button class="main-button">Buy</button>
                        </div>
                    @endforeach
                </div>
                <div class="products-column">
                    <h2>Produk Cafe</h2>
                    @foreach($cafeProducts as $cafeProduct)
                        <div class="main-content">
                            <div class="main-title">{{ $cafeProduct->name }}</div>
                            <div class="main-price">${{ $cafeProduct->price }}</div>
                            <div class="main-description">{{ $cafeProduct->description }}</div>
                            <button class="main-button">Buy</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
        
    </div>
    <footer>
        <p>Footer</p>
    </footer>

    <!-- Modal -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Tambah Produk Warnet</h2>
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <label for="productName">Nama:</label>
                <input type="text" id="productName" name="productName" required><br><br>
                <label for="productDescription">Deskripsi:</label>
                <textarea id="productDescription" name="productDescription" required></textarea><br><br>
                <label for="productPrice">Harga:</label>
                <input type="number" id="productPrice" name="productPrice" required><br><br>
                <label for="productImage">Gambar:</label>
                <input type="file" id="productImage" name="productImage" required><br><br>
                <button type="submit" class="save-button">Simpan</button>
            </form>
        </div>
    </div>

    <!-- Modal for Tambah Produk Cafe -->
    <div id="addCafeProductModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Tambah Produk Cafe</h2>
            <form method="POST" action="{{ route('cafeProducts.store') }}" enctype="multipart/form-data" onsubmit="formatPriceBeforeSubmit()">
                @csrf
                <label for="cafeProductName">Nama:</label>
                <input type="text" id="cafeProductName" name="cafeProductName" required><br><br>
                <label for="cafeProductDescription">Deskripsi:</label>
                <textarea id="cafeProductDescription" name="cafeProductDescription" required></textarea><br><br>
                <label for="cafeProductPrice">Harga:</label>
                <input type="number" id="cafeProductPrice" name="cafeProductPrice" required step="0.01"><br><br>
                <label for="cafeProductImage">Gambar:</label>
                <input type="file" id="cafeProductImage" name="cafeProductImage" required><br><br>
                <button type="submit" class="save-button">Simpan</button>
            </form>
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const strTime = ((hours % 12) || 12) + ':' + (minutes < 10 ? '0' + minutes : minutes);
            const day = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            
            document.getElementById('time-now').textContent = strTime;
            document.getElementById('am-pm').textContent = ampm;
            document.getElementById('date-now').textContent = day;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
    <script>
        var modal = document.getElementById("addProductModal");
        var btn = document.getElementById("addProductButton");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <script>
        var cafeModal = document.getElementById("addCafeProductModal");
        var cafeBtn = document.getElementById("addCafeProductButton");
        var cafeSpan = document.getElementsByClassName("close")[1]; // Assuming the second close button

        cafeBtn.onclick = function() {
            cafeModal.style.display = "block";
        }

        cafeSpan.onclick = function() {
            cafeModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == cafeModal) {
                cafeModal.style.display = "none";
            }
        }
    </script>
    <script>
        document.getElementById('cafeProductPrice').addEventListener('input', function (e) {
            var value = e.target.value.replace(/[^,\d]/g, '').toString();
            var split = value.split(',');
            var sisa = split[0].length % 3;
            var rupiah = split[0].substr(0, sisa);
            var ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                var separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            e.target.value = rupiah;
        });

        function formatPriceBeforeSubmit() {
            var priceInput = document.getElementById('cafeProductPrice');
            priceInput.value = priceInput.value.replace(/\./g, '').replace(/,/g, '.');
        }
    </script>
</body>