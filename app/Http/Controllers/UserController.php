<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display all products on the user index page
    public function index()
    {
        $products = Product::paginate(25); // Paginasi ditambahkan di sini
        return view('user.index', compact('products'));
    }

    // Handle product search
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::where('name', 'like', '%' . $keyword . '%')->paginate(25); // Paginasi ditambahkan untuk hasil pencarian
        return view('user.index', compact('products'));
    }

    // Display the user's cart
    public function cart()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('user.cart', compact('cartItems', 'totalPrice'));
    }

    // Edit user profile
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    // Update profile information
    public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Validasi input
    $request->validate([
        'name' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
        'dob' => 'nullable|date',  // Pastikan format tanggal valid
        'gender' => 'nullable|string|in:male,female,other',  // Pastikan gender valid
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
    ]);

    // Update data pengguna
    if ($request->has('name')) {
        $user->name = $request->name;
    }
    if ($request->has('email')) {
        $user->email = $request->email;
    }
    if ($request->has('dob')) {
        $user->dob = $request->dob;
    }
    if ($request->has('gender')) {
        $user->gender = $request->gender;
    }

    // Update foto profil jika ada
    if ($request->hasFile('profile_image')) {
        if ($user->profile_image && Storage::exists('public/profile_images/' . $user->profile_image)) {
            Storage::delete('public/profile_images/' . $user->profile_image);
        }

        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        $user->profile_image = basename($imagePath);
    }

    // Simpan perubahan
    $user->save();

    // Kembali ke halaman sebelumnya dengan pesan sukses
    return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
}




    // Transaction history
    public function transaction()
    {
        $transactions = Transaction::where('user_id', auth()->id())->get();
        return view('user.transactions', compact('transactions'));
    }

    // Remove item from cart
    public function removeFromCart($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();
        return redirect()->route('user.cart')->with('success', 'Product removed from cart.');
    }

    // Add item to cart
    public function addToCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        $existingCartItem = Cart::where('product_id', $id)->where('user_id', Auth::id())->first();
        if ($existingCartItem) {
            $existingCartItem->update([
                'quantity' => $existingCartItem->quantity + $request->quantity
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => $request->quantity
            ]);
        }
        return redirect()->back()->with('success', 'Product successfully added to the cart!');
    }

    // Update cart item quantity
    public function updateCart(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->update(['quantity' => $request->quantity]);
        return redirect()->route('user.cart')->with('success', 'Cart updated.');
    }

    // Checkout
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cartItems = Cart::where('user_id', $user->id)->get();
        $totalPrice = 0;

        $items = [];
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->product->price * $cartItem->quantity;
            $items[] = [
                'id' => $cartItem->product->id,
                'name' => $cartItem->product->name,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ];
            $cartItem->delete(); // Delete from cart
        }

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'items' => json_encode($items),
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('user.transactions')->with('success', 'Transaksi berhasil!');
    }

    // Display transaction history for the user
    public function transactions()
    {
        $transactions = Transaction::where('user_id', auth()->id())->get();
        return view('user.transactions', compact('transactions'));
    }

    // Display transactions for the admin
    public function adminTransactions()
    {
        $transactions = Transaction::with('user')->get();
        return view('admin.transactions', compact('transactions'));
    }

    // Display a single product's details
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('user.product', compact('product'));
    }
}
