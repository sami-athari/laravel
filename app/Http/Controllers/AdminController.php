<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $products = Product::paginate(25);  // Paginasi untuk produk
        return view('admin.index', compact('products'));
    }

    // Menampilkan form untuk membuat produk baru
    public function create()
    {
        return view('admin.create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        // Validasi input produk
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|image',
            'stock' => 'required|integer|min:0', // Validasi stok
        ]);

        // Upload gambar produk
        $imagePath = $request->file('image')->store('products', 'public');

        // Buat produk baru
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $imagePath,
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.index')->with('success', 'Product created successfully.');
    }

    // Menampilkan form untuk mengedit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.edit', compact('product'));
    }

    // Memperbarui produk
    public function update(Request $request, $id)
    {
        // Validasi input produk
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        // Update data produk
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.index')->with('success', 'Product updated successfully.');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.index')->with('success', 'Product deleted successfully.');
    }

    // Fungsi pencarian produk berdasarkan nama
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::where('name', 'like', '%' . $keyword . '%')->paginate(25);  // Pencarian produk
        return view('admin.index', compact('products'));
    }

    // Menampilkan daftar transaksi pengguna
    public function transactions(Request $request)
    {
        $search = $request->get('search');
        $transactions = Transaction::with('user')
            ->whereJsonContains('items->product_name', $search) // Menggunakan JSON path untuk mencari nama produk
            ->orWhereHas('user', function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(25);

        return view('admin.transactions', compact('transactions'));
    }

    public function confirm($id)
{
    $transaction = Transaction::findOrFail($id);

    // Mengubah status transaksi menjadi 'completed'
    $transaction->status = 'completed';
    $transaction->save();

    // Redirect kembali ke halaman daftar transaksi dengan pesan sukses
    return redirect()->route('admin.transactions.index')->with('success', 'Transaction confirmed successfully.');
}


}
