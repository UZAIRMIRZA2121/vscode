<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addProductToCart(Request $request)
    {
        // Get the product ID from the request
        $productId = $request->input('product_id');
        // Get the user ID from the authenticated user (assuming you're using Laravel's authentication)
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the user ID from the authenticated user
            $userId = auth()->id();
        } else {
            // Fallback to using user ID from request
            $userId = $request->user()->id;
        }

        // Check if the user has an active cart
        $cart = Cart::where('user_id', $userId)->where('status', 'active')->first();

        // If the user doesn't have an active cart, create a new one
        if (!$cart) {
            $cart = new Cart();
            $cart->user_id = $userId;
            $cart->status = 'active';
            $cart->save();
        }

        // Check if the product already exists in the cart items
        $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();

        // If the product already exists, update its quantity
        if ($cartItem) {
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            // Otherwise, add a new cart item
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->product_id = $productId;
            // You may need to adjust the price based on your application logic
            $cartItem->price = 0; // Assuming you'll calculate the price later
            $cartItem->quantity = 1;
            $cartItem->save();
        }

        // Optionally, you can redirect the user back or return a response
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function showCart()
    {
        // Retrieve cart items associated with the authenticated user
        $userId = auth()->id(); // Assuming the user is authenticated
        $cartItems = CartItem::with('product')->whereHas('cart', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 'active');
        })->get();

        // Pass cart items along with their total prices to the frontend view
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('frontend.cart', compact('cartItems', 'totalPrice'));
    }

    public function removeProductFromCart(Request $request)
    {
        $productId = $request->input('product_id');
        $userId = auth()->id(); // Assuming the user is authenticated

        // Find the cart item associated with the product ID and the authenticated user
        $cartItem = CartItem::whereHas('cart', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 'active');
        })->where('product_id', $productId)->first();

        if ($cartItem) {
            // Delete the cart item from the database
            $cartItem->delete();
            return redirect()->back()->with('success', 'Product removed from cart successfully!');
        }

        return redirect()->back()->with('error', 'Product not found in cart!');
    }

    public function updateProductQuantity(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $userId = auth()->id(); // Assuming the user is authenticated

        // Find the cart item associated with the product ID and the authenticated user
        $cartItem = CartItem::whereHas('cart', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 'active');
        })->where('product_id', $productId)->first();

        if ($cartItem) {
            // If quantity is greater than 0, update the quantity and recalculate the price
            if ($quantity > 0) {
                $cartItem->quantity = $quantity;
                $cartItem->price = $cartItem->product->price * $quantity; // Recalculate the price
                $cartItem->save();
            } else {
                // If quantity is 0 or less, remove the product from the cart
                $cartItem->delete();
            }

            return redirect()->back()->with('success', 'Cart updated successfully!');
        }

        return redirect()->back()->with('error', 'Product not found in cart!');
    }

    public function checkout()
    {   
        
        // Retrieve cart items associated with the authenticated user
        $userId = auth()->id(); // Assuming the user is authenticated
        $cartItems = CartItem::with('product')->whereHas('cart', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 'active');
        })->get();

        // Pass cart items along with their total prices to the frontend view
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('frontend.checkout', compact('cartItems', 'totalPrice'));
    }
}
