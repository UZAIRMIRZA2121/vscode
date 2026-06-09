<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use App\Models\PrescriptionRequest;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ContactUs;
use App\Models\Nurse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $users = User::all();
        $orders = Order::with('user')->get();
        $nurses = Nurse::all();


        return view('admin.index', compact('products', 'categories', 'users', 'orders','nurses'));
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function prescription_request()
    {

        $pending_prescriptions = PrescriptionRequest::all();

        return view('admin.precrequest', compact('pending_prescriptions'));
    }

    public function updateStatus(Request $request)
    {
        // Validate the request data
        $request->validate([
            'prescription_id' => 'required|exists:prescription_requests,id',
            'status' => 'required|in:accepted,rejected' // Allow both "accepted" and "rejected" statuses
        ]);

        // Update the status of the prescription
        $prescription = PrescriptionRequest::findOrFail($request->prescription_id);
        $prescription->status = $request->status;
        $prescription->save();
        if ($request->status == 'accepted') {
            // Get the user ID associated with the prescription
            $userId = $prescription->user_id;

            // Get the product ID from the request
            $productId = $prescription->product_id;

            // Ensure that the product ID is not null
            if (!$productId) {
                return redirect()->back()->with('error', 'Product ID is required');
            }

            // Retrieve the product associated with the provided product ID
            $product = Product::find($productId);

            // Ensure that the product exists
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found');
            }

            // Retrieve the current cart for the user
            $cart = Cart::where('user_id', $userId)->where('status', 'active')->first();

            // If the user doesn't have an active cart, create a new one
            if (!$cart) {
                $cart = new Cart();
                $cart->user_id = $userId;
                $cart->status = 'active';
                $cart->save();
            }

            // Check if the product already exists in the user's cart
            $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();

            if ($cartItem) {
                // If the same product already exists in the user's cart, increase its quantity
                $cartItem->quantity++;
                $cartItem->save();
            } else {
                // Add new product to the user's cart
                $cartItem = new CartItem();
                $cartItem->cart_id = $cart->id;
                $cartItem->product_id = $productId;
                $cartItem->quantity = 1;
                $cartItem->price = $product->price; // Set the price of the product
                $cartItem->save();
            }
            return redirect()->back()->with('success', 'Prescription status updated successfully and product added to customer cart');
        } 
        else {
            return redirect()->back()->with('error', 'Prescription are Rejected');
        }

        // Optionally, you can redirect the user back or return a response
        
    }

    public function alluser()
    {
        $allusers = user::where('role','=','user')->get();
        return view('admin.alluser.index',compact('allusers'));
    }

    public function contactus()
    {
        $contactus = ContactUs::all();
        return view('admin.contactus.index',compact('contactus'));
    }
    public function contactusdestroy($id)
    {
        // Find the contact by ID
        $contact = ContactUs::find($id);

        // Check if the contact exists
        if (!$contact) {
            return redirect()->back()->with('error', 'Contact not found!');
        }

        // Delete the contact
        $contact->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Contact deleted successfully!');
    }
    public function userdestroy(User $user)
    {
        // Perform deletion logic here
        $user->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
    public function adminedit()
    {
       
        // Redirect back with a success message
        return view('admin.profile.edit');
    }
    public function updateadmin(Request $request)
    {
        // dd($request->all());
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Update the user's information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->city = $request->city;
        $user->phone = $request->phone;

        // Update the password if provided
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        // Save the changes
        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'User information updated successfully');
    }

}
