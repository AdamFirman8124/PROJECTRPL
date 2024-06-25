<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::all();
            return view('game.index', compact('products'));
        } catch (\Exception $e) {
            Log::error('Failed to retrieve products: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data produk.');
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'productName' => 'required|string|max:255',
                'productDescription' => 'required|string',
                'productPrice' => 'required|numeric',
                'productImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $imagePath = $request->file('productImage')->store('product_images', 'public');

            $product = new Product([
                'name' => $request->productName,
                'description' => $request->productDescription,
                'price' => $request->productPrice,
                'image' => $imagePath,
            ]);
            $product->save();

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error saving product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                return view('product.show', compact('product'));
            } else {
                Log::error('Product not found with ID: ' . $id);
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }
        } catch (\Exception $e) {
            Log::error('Error retrieving product with ID: ' . $id . ' - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data produk.');
        }
    }

    public function edit(string $id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                return view('product.edit', compact('product'));
            } else {
                Log::error('Product not found with ID: ' . $id);
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }
        } catch (\Exception $e) {
            Log::error('Error retrieving product for editing with ID: ' . $id . ' - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil data produk untuk diedit.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                $request->validate([
                    'productName' => 'required|string|max:255',
                    'productDescription' => 'required|string',
                    'productPrice' => 'required|numeric',
                    'productImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                if ($request->hasFile('productImage')) {
                    $imagePath = $request->file('productImage')->store('product_images', 'public');
                    $product->image = $imagePath;
                }

                $product->name = $request->productName;
                $product->description = $request->productDescription;
                $product->price = $request->productPrice;
                $product->save();
                return redirect()->back()->with('success', 'Produk berhasil diperbarui!');
            } else {
                Log::error('Product not found with ID: ' . $id);
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            if ($product) {
                Purchase::where('product_id', $id)->delete();
                $product->delete();
                return redirect()->back()->with('success', 'Produk berhasil dihapus.');
            }
            Log::error('Product not found with ID: ' . $id);
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Error deleting product with ID: ' . $id . ' - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus produk.');
        }
    }

    public function checkout()
    {
        try {
            $cart = session()->get('cart', []);
            if (empty($cart)) {
                Log::error('No products in cart at checkout');
                return redirect()->back()->with('error', 'Tidak ada produk dalam keranjang.');
            }

            foreach ($cart as $id => $product) {
                try {
                    DB::beginTransaction();
                    $purchase = new Purchase([
                        'product_id' => $id,
                        'user_id' => auth()->id(),
                        'quantity' => 1,
                        'total_price' => $product->price
                    ]);
                    if (!$purchase->save()) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Failed to complete checkout.');
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Transaction failed: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Transaction failed: ' . $e->getMessage());
                }
            }

            session()->put('cart', $cart);
            return view('checkout.index', ['cart' => $cart]);
        } catch (\Exception $e) {
            Log::error('Checkout process failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Proses checkout gagal.');
        }
    }

    public function purchase(Request $request)
    {
        try {
            $cart = session('cart', []);
            foreach ($cart as $id => $productDetails) {
                $product = Product::find($id);
                if (!$product) {
                    Log::error('Product not found during purchase with ID: ' . $id);
                    continue;
                }

                $totalPrice = $product->price * $request->input('quantity.' . $id, 1);
                $note = $request->input('notes.' . $id, '');

                $purchase = new Purchase([
                    'product_id' => $id,
                    'user_id' => auth()->id(),
                    'quantity' => $request->input('quantity.' . $id, 1),
                    'total_price' => $totalPrice,
                    'notes' => $note
                ]);
                if (!$purchase->save()) {
                    Log::error('Failed to save purchase for product ID: ' . $id);
                }
            }

            session()->forget('cart');
            return redirect()->route('products.index')->with('success', 'Pembelian berhasil dilakukan.');
        } catch (\Exception $e) {
            Log::error('Purchase process failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Proses pembelian gagal.');
        }
    }

    public function removeFromCart($id)
    {
        try {
            $cart = session()->get('cart', []);
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            } else {
                Log::info('Product not found in cart with ID: ' . $id);
            }
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        } catch (\Exception $e) {
            Log::error('Failed to remove product from cart with ID: ' . $id . ' - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus produk dari keranjang.');
        }
    }

    public function addToCart($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                Log::error('Product not found when adding to cart with ID: ' . $id);
                return redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "image" => $product->image
                ];
            }

            session()->put('cart', $cart);
            return redirect()->route('checkout');
        } catch (\Exception $e) {
            Log::error('Failed to add product to cart with ID: ' . $id . ' - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan produk ke keranjang.');
        }
    }
}
