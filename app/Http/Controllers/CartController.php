<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseHistory;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);

            if (! $product) {
                continue;
            }

            $subtotal = $product->price * $quantity;
            $total += $subtotal;

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $nextQuantity = ($cart[$product->id] ?? 0) + 1;

        if ($nextQuantity > $product->stock) {
            if ($request->expectsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok produk ' . $product->title . ' tidak mencukupi.',
                ], 422);
            }

            return back()->with('error', 'Stok produk ' . $product->title . ' tidak mencukupi.');
        }

        $cart[$product->id] = $nextQuantity;
        session()->put('cart', $cart);

        $count = array_sum($cart);

        if ($request->expectsJson() || $request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'count' => $count,
                'message' => $product->title . ' ditambahkan ke keranjang.',
            ]);
        }

        return back()->with('success', $product->title . ' ditambahkan ke keranjang.');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);

        if ($validated['quantity'] > $product->stock) {
            return back()->with('error', 'Stok produk ' . $product->title . ' tidak mencukupi.');
        }

        if ($validated['quantity'] <= 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = $validated['quantity'];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        unset($cart[$product->id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang masih kosong.');
        }

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);

            if (! $product) {
                continue;
            }

            if ($quantity > $product->stock) {
                return redirect()->route('cart')->with('error', 'Stok produk ' . $product->title . ' tidak mencukupi untuk checkout.');
            }

            $subtotal = $product->price * $quantity;
            $total += $subtotal;

            $items[] = [
                'title' => $product->title,
                'image_url' => $product->image_url,
                'quantity' => $quantity,
                'price' => $product->price,
                'subtotal' => $subtotal,
            ];
        }

        $invoice = 'NV-' . now()->format('YmdHis');
        $receipt = [
            'invoice' => $invoice,
            'date' => now()->format('d M Y, H:i'),
            'items' => $items,
            'total' => $total,
        ];

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);

            if ($product) {
                $product->decrement('stock', $quantity);
            }
        }

        PurchaseHistory::create([
            'user_id' => auth()->id(),
            'invoice' => $invoice,
            'items' => $items,
            'total' => $total,
            'purchase_date' => now(),
        ]);

        session()->forget('cart');

        return redirect()->route('cart')->with('checkout_receipt', $receipt);
    }

    public function history()
    {
        $histories = PurchaseHistory::where('user_id', auth()->id())
            ->orderByDesc('purchase_date')
            ->get();

        return view('cart.history', compact('histories'));
    }
}
