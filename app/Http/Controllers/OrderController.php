<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Stripe\Exception\CardException;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        // Find the existing order with the given tracking code
        $existingOrder = Order::where('tracking_code', $request->tracking_code)->first();

        // If an existing order is found, delete it along with its order items
        if ($existingOrder) {
            // Delete the order items associated with the existing order
            OrderItem::where('order_id', $existingOrder->id)->delete();
            // Delete the existing order
            $existingOrder->delete();
        }

        // Get the authenticated user
        $user = Auth::user();
        // Update the user's information
        $user->city = $request->city;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->save();

        // Create an order
        $order = new Order();
        $order->tracking_code = $request->tracking_code;
        $order->user_id = Auth::id(); // You need to define the generateTrackingCode function
        $order->payment_type = $request->payment_method; // You need to define the generateTrackingCode function

        if ($request->payment_method == 'cash') {
            $order->save();
            $totalamount = 0;
            // Insert order items
            foreach ($request->products as $productId => $productData) {
                $product = Product::find($productId); // Assuming the product ID is valid
                if ($product) {
                    // Calculate the total price for the order item
                    $price = $product->price * $productData['quantity'];
                    $totalamount += $price;
                    // Create and save the order item
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $productId;
                    $orderItem->quantity = $productData['quantity'];
                    $orderItem->price = $price;
                    $orderItem->save();
                }
            }

            $order->amount = $totalamount;
            $order->save();
            // Delete cart items where the product_id is 5
            Cart::where('user_id', Auth::id())->delete();
            $products = Product::all();
            return redirect()->route('product', compact('products'))->with('success', 'Order placed successfully! Your Tracking ID is ' . $order->tracking_code);
        } else {

            $order->save();
            $totalamount = 0;
            // Insert order items
            foreach ($request->products as $productId => $productData) {
                $product = Product::find($productId); // Assuming the product ID is valid
                if ($product) {
                    // Calculate the total price for the order item
                    $price = $product->price * $productData['quantity'];
                    $totalamount += $price;
                    // Create and save the order item
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $productId;
                    $orderItem->quantity = $productData['quantity'];
                    $orderItem->price = $price;
                    $orderItem->save();
                }
            }

            $order->amount = $totalamount;
            $order->status = 'Paid';
            $order->save();
            // Enter Your Stripe Secret
            \Stripe\Stripe::setApiKey('sk_test_51OzHsOEL7eSHZky6l8GtEHnfLqXolCBsSSKs2imzhpSAvzt7DfsnGNc3rAOkfoKZRC14bobYFJ0kEk4xnX2zr4XU00C3Q0WMTy');

            $amount = $totalamount;
            $amount *= 100;
            $amount = (int) $amount;

            $payment_intent = \Stripe\PaymentIntent::create([
                'description' => 'Stripe Test Payment',
                'amount' => $amount,
                'currency' => 'USD',
                'payment_method_types' => ['card'],
            ]);
            $intent = $payment_intent->client_secret;

            return view('frontend.cardpayment', compact('intent'));
        }
    }



    public function afterPayment()
    {
        // Delete cart items where the product_id is 5
        Cart::where('user_id', Auth::id())->delete();
        $products = Product::all();

        return redirect()->route('product', compact('products'))->with('success', 'Order placed successfully!');
    }

    public function showOrderRequestForm()
    {
        return view('frontend.ordertracking');
    }
    public function request(Request $request)
    {
        $searchorders = null;

        if ($request->has('tracking_order')) {
            $searchorders = Order::where('tracking_code', '=', $request->tracking_order)->first();
        }

        // Check if $searchorders is null
        if ($searchorders === null) {
            // Provide a message indicating that the tracking code does not exist
            $errorMessage = "Tracking code '{$request->tracking_order}' does not exist.";
            return view('frontend.ordertracking', compact('errorMessage'));
        }

        return view('frontend.ordertracking', compact('searchorders'));
    }
    public function acceptRequest($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'accepted';
        $order->save();
    
        return redirect()->back()->with('success', "Order accepted successfully");
    }
    
    public function rejectRequest($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'rejected';
        $order->save();
    
        return redirect()->back()->with('error', "Order rejected successfully");
    }
}
