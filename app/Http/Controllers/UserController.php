<?php

namespace App\Http\Controllers;

use App\Models\NurseHire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyAccountMail;
use Illuminate\Support\Facades\Session;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('frontend.dashboard.index');
    }

    public function store(Request $request)
    {
        
         // Check if the email exists in the database and belongs to a user other than the current user
         $existingUser = User::where('email', $request->email)->first();

         if ($existingUser) {
             // If the email exists for another user, return with an error message
             return redirect()->back()->with(['alert' => 'The email has already been taken.']);
         }
        // Generate a random verification token
        $token = Str::random(60);

        Mail::to($request->email)->send(new VerifyAccountMail($token));
        // Create a new user with the verification token
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => $token,
        ]);
     
        // Send verification email
      

        // Optionally, you can authenticate the user here if desired

        // Flash message to be shown on login page
        $request->session()->flash('verification_message', 'Please check your email for verification.');

        // Redirect the user after successful registration
        return redirect()->route('login');
    }

    public function verify_email($token)
    {
        $user = User::where('remember_token', $token)->first();
    
        if (!$user) {
            return redirect('/')->with('error', 'Invalid verification token.');
        }
    
        // Optionally, you can clear the verification token after verification
        $user->remember_token = null;
        $user->save();
    
        // Log in the user
        Auth::login($user);
    
        return redirect('/')->with('success', 'Your account has been successfully verified.');
    }
    public function verify(Request $request)
    {
        // Find the user by token
        $user = User::where('email', $request->email)->first();
    
        // Check if the user exists
        if (!$user) {
            return redirect('auth.login')->with('error', 'Invalid verification token.');
        }
    
        // Validate request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
        ]);
    
        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->remember_token = null; // Clear the verification token
        $user->save();
    
        // Log in the user
        Auth::login($user);
    
        return redirect('/')->with('success', 'Your account has been successfully verified and your password has been updated.');
    }
    
    



    public function edit()
    {
        return view('frontend.dashboard.edit');
    }
    public function update(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'city' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if the email exists in the database and belongs to a user other than the current user
        $existingUser = User::where('email', $request->email)->where('id', '!=', $user->id)->first();

        if ($existingUser) {
            // If the email exists for another user, return with an error message
            return redirect()->back()->with(['error' => 'The email has already been taken.']);
        }

        // Update the user's information
        $user->name = $request->name;
        $user->email = $request->email;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->save();

        // Redirect the user back with a success message
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
   
    public function order_dashboard()
    {   
        $orders = Order::where('user_id', Auth::id())->paginate(8);

        return view('frontend.dashboard.order.index',compact('orders'));
    }

    public function nurse_dashboard()
    {   
        $nurses = NurseHire::where('user_id' ,'=',Auth::id())->get();
        return view('frontend.dashboard.nurse.index',compact('nurses'));
    }
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
    
        $user = User::where('email', $email)->first();
    
        if ($user) {
            return response()->json(['exists' => true]);
        }
    
        return response()->json(['exists' => false]);
    }

}
