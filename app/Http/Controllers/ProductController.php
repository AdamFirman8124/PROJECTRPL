<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase; // Tambahkan ini untuk memperbaiki error 'Undefined type Purchase'
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk memperbaiki error 'Undefined type DB'

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('Memulai proses menampilkan semua produk.');
        $products = Product::all();
        Log::info('Menampilkan semua produk.', ['products' => $products]);
        return view('game.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info('Masuk ke halaman pembuatan produk baru.');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Memulai proses penyimpanan produk baru.');
        try {
            Log::info('Data yang diterima', ['data' => $request->all()]);

            $request->validate([
                'productName' => 'required|string|max:255',
                'productDescription' => 'required|string',
                'productPrice' => 'required|numeric',
                'productImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imagePath = $request->file('productImage')->store('product_images', 'public');
            Log::info('Gambar disimpan', ['path' => $imagePath]);

            $product = new Product([
                'name' => $request->productName,
                'description' => $request->productDescription,
                'price' => $request->productPrice,
                'image' => $imagePath,
            ]);
            Log::info('Memulai penyimpanan produk baru ke database.');
            $product->save();
            Log::info('Produk baru berhasil disimpan', ['product' => $product]);

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menyimpan produk', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        Log::info('Memulai proses menampilkan produk dengan ID: ' . $id);
        $product = Product::find($id);
        if ($product) {
            Log::info('Produk ditemukan', ['product' => $product]);
            return view('product.show', compact('product'));
        } else {
            Log::error('Produk dengan ID: ' . $id . ' tidak ditemukan.');
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Log::info('Memulai proses edit untuk produk dengan ID: ' . $id);
        $product = Product::find($id);
        if ($product) {
            Log::info('Produk ditemukan untuk diedit', ['product' => $product]);
            return view('product.edit', compact('product'));
        } else {
            Log::error('Produk dengan ID: ' . $id . ' tidak ditemukan.');
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Log::info('Memulai proses memperbarui produk dengan ID: ' . $id);
        try {
            $product = Product::find($id);
            if ($product) {
                Log::info('Produk ditemukan untuk diperbarui', ['product' => $product]);

                $request->validate([
                    'productName' => 'required|string|max:255',
                    'productDescription' => 'required|string',
                    'productPrice' => 'required|numeric',
                    'productImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                if ($request->hasFile('productImage')) {
                    $imagePath = $request->file('productImage')->store('product_images', 'public');
                    $product->image = $imagePath;
                    Log::info('Gambar diperbarui', ['path' => $imagePath]);
                }

                $product->name = $request->productName;
                $product->description = $request->productDescription;
                $product->price = $request->productPrice;
                Log::info('Memulai penyimpanan perubahan produk ke database.');
                $product->save();
                Log::info('Produk berhasil diperbarui', ['product' => $product]);
                return redirect()->back()->with('success', 'Produk berhasil diperbarui!');
            } else {
                Log::error('Produk dengan ID: ' . $id . ' tidak ditemukan.');
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }
        } catch (\Exception $e) {
            Log::error('Kesalahan saat memperbarui produk', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Log::info('Memulai proses menghapus produk dengan ID: ' . $id);
        $product = Product::find($id);
        if ($product) {
            // Hapus semua pembelian yang terkait dengan produk ini
            Purchase::where('product_id', $id)->delete();
            Log::info('Semua pembelian terkait dengan produk ID: ' . $id . ' telah dihapus.');

            // Sekarang aman untuk menghapus produk
            Log::info('Memulai penghapusan produk dari database.');
            $product->delete();
            Log::info('Produk dengan ID: ' . $id . ' berhasil dihapus.');
            return redirect()->back()->with('success', 'Produk berhasil dihapus.');
        }
        Log::error('Produk dengan ID: ' . $id . ' tidak ditemukan.');
        return redirect()->back()->with('error', 'Produk tidak ditemukan.');
    }

    public function checkout()
    {
        Log::info('Memulai proses checkout.');
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            Log::error('Tidak ada produk dalam keranjang saat checkout');
            return redirect()->back()->with('error', 'Tidak ada produk dalam keranjang.');
        }

        Log::info('Memulai proses checkout untuk semua produk dalam keranjang');
        foreach ($cart as $id => $product) {
            // Membuat entri baru di tabel purchases
            try {
                DB::beginTransaction();
                $purchase = new Purchase([
                    'product_id' => $id,
                    'user_id' => auth()->id(),
                    'quantity' => 1, // asumsi jumlah default adalah 1
                    'total_price' => $product->price
                ]);
                Log::info('Memulai penyimpanan entri pembelian baru ke database.');
                if (!$purchase->save()) {
                    Log::error('Gagal menyimpan data purchase untuk produk dengan ID: ' . $id);
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Gagal melakukan checkout.');
                }
                DB::commit();
                Log::info('Entri pembelian baru berhasil dibuat untuk produk dengan ID: ' . $id);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Transaksi gagal: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Transaksi gagal: ' . $e->getMessage());
            }
        }

        session()->put('cart', $cart);
        Log::info('Checkout selesai untuk semua produk dalam keranjang');
        return view('checkout.index', ['cart' => $cart]);
    }

    public function purchase(Request $request)
    {
        Log::info('Data request:', $request->all()); // Tambahkan ini untuk melihat semua data yang diterima
        $cart = session('cart', []);
        foreach ($cart as $id => $productDetails) {
            $product = Product::find($id);
            if (!$product) {
                Log::error('Produk dengan ID: ' . $id . ' tidak ditemukan saat pembelian');
                continue;
            }

            $totalPrice = $product->price * $request->input('quantity.' . $id, 1);
            $note = $request->input('notes.' . $id, ''); // Pastikan ini sesuai dengan key yang dikirim dari form
            Log::info('Mencoba menyimpan catatan untuk produk', ['product_id' => $id, 'note' => $note]);

            $purchase = new Purchase([
                'product_id' => $id,
                'user_id' => auth()->id(),
                'quantity' => $request->input('quantity.' . $id, 1),
                'total_price' => $totalPrice,
                'notes' => $note
            ]);
            Log::info('Memulai penyimpanan pembelian baru ke database.');
            if ($purchase->save()) {
                Log::info('Catatan berhasil disimpan', ['product_id' => $id]);
            } else {
                Log::error('Gagal menyimpan catatan', ['product_id' => $id]);
            }
        }

        session()->forget('cart'); // Bersihkan keranjang setelah pembelian
        Log::info('Keranjang dibersihkan setelah pembelian');
        return redirect()->route('products.index')->with('success', 'Pembelian berhasil dilakukan.');
    }

    public function removeFromCart($id)
    {
        Log::info('Memulai proses menghapus produk dari keranjang dengan ID: ' . $id);
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            Log::info('Produk dengan ID: ' . $id . ' berhasil dihapus dari keranjang');
        } else {
            Log::info('Produk dengan ID: ' . $id . ' tidak ditemukan di keranjang');
        }
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function addToCart($id)
    {
        Log::info('Memulai proses menambahkan produk ke keranjang dengan ID: ' . $id);
        $product = Product::find($id);
        if (!$product) {
            Log::error('Produk dengan ID: ' . $id . ' tidak ditemukan saat menambahkan ke keranjang');
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }
    
        $cart = session()->get('cart', []);
        // Periksa jika produk sudah ada di keranjang, tambahkan jumlahnya
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            Log::info('Jumlah produk dengan ID: ' . $id . ' ditambahkan di keranjang');
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
            Log::info('Produk dengan ID: ' . $id . ' ditambahkan ke keranjang');
        }
        
        session()->put('cart', $cart);
        Log::info('Keranjang diperbarui dengan produk baru');
        return redirect()->route('checkout');
    }
}
