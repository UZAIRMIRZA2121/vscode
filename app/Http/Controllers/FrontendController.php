<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MainCategory;
use App\Models\ContactUs;
use App\Models\User;
use App\Models\UserSearchHistory;
use App\Models\PrescriptionRequest;
use App\Models\Product;
use App\Models\Nurse;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        $products = Product::inRandomOrder()->paginate(10);
        $products_discount = Product::whereNotNull('discount')->inRandomOrder()->paginate(8);

        $categories = Category::all();
        $users = User::all();
        $nurses = Nurse::all();

        // Get the user's IP address
        $ipAddress = request()->ip();

        // Get the authenticated user ID
        $user_id = Auth::id();

        // Check if user's last query exists
        $lastQuery = UserSearchHistory::where(function ($query) use ($ipAddress, $user_id) {
            $query->where('ip_address', $ipAddress)
                ->orWhere('user_id', $user_id);
        })
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastQuery) {
            // Assuming the search query is stored in the 'query' column of the UserSearchHistory table
            $searchQuery = $lastQuery->query;

            // Search for products by name
            $searched_products = Product::where('name', 'like', '%' . $searchQuery . '%')->get();

            return view('frontend.index', compact('products', 'products_discount', 'categories', 'users', 'nurses', 'searched_products'));
        } else {
            return view('frontend.index', compact('products', 'products_discount', 'categories', 'users', 'nurses'));
        }
    }
    public function category(MainCategory $category = null)
    {
        
        if ($category) {
          
            $category_ids = Category::where('main_category_id', $category->id)->pluck('id')->toArray();
            $category_name = $category->name;
            $selectedCategoryId = $category->id;
            $products = Product::whereIn('category_id', $category_ids)->paginate(8);
        } else {
            $category_name = 'All Categories';
            $products = Product::paginate(8);
        }
        $maincategories=  MainCategory::all();
        return view('frontend.category-grid', compact('products', 'category_name','maincategories','selectedCategoryId'));
    }

    public function product(Product $product = null)
    {
        $related_products = [];

        if ($product) {
            $product = Product::find($product->id);
            if ($product) {
                // Check if product quantity is zero
                if ($product->qty == 0) {
                    $related_product_ids = explode(',', $product->related_product_id);
                    $related_products = Product::whereIn('id', $related_product_ids)->get();
                  
                    return view('frontend.single-product-details', compact('product', 'related_products'));
                } else {
                    $related_product_ids = explode(',', $product->related_product_id);
                $related_products = Product::whereIn('id', $related_product_ids)->get();
                return view('frontend.single-product-details', compact('product', 'related_products'));
                }
            }
        } else {
            // If $product is null or not provided, display all products
            $products = Product::paginate(8);
            return view('frontend.all-product', compact('products'));
        }
      
    }

    public function nurse($nurse_id = null)
    {
        if ($nurse_id) {
            // If a nurse ID is provided, fetch the details of that nurse
            $nurse = Nurse::find($nurse_id);
            if (!$nurse) {
                // Handle case where nurse is not found
                abort(404);
            }
            // Return the single nurse details view
            return view('frontend.single-nurse-details', compact('nurse'));
        } else {
            // If no nurse ID is provided, fetch all nurses
            $nurses = Nurse::where('availability','=',1)->get();
            // Return the view to display all nurses
            return view('frontend.all-nurses', compact('nurses'));
        }
    }

    public function productsearch(Request $request)
    {
        // dd ($request->all());
        // Validate the incoming request data
        $request->validate([
            'query' => 'required|string',
        ]);
        $query = $request->input('query');
        $ipAddress = $request->ip();
        $user_id = Auth::id() ?? null;
        // Perform the search using Eloquent
        $products = Product::where('name', 'like', '%' . $query . '%')
        ->orWhere('formula', 'like', '%' . $query . '%')
        ->paginate(10);
        // Change 10 to the number of items you want per page
        // Check if user's last query exists
        $lastQuery = UserSearchHistory::where('ip_address', $ipAddress)->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastQuery) {
            // Update the existing record
            $lastQuery->update(['query' => $query]);
        } else {
            // Insert a new record
            UserSearchHistory::create(['query' => $query, 'user_id' => $user_id, 'ip_address' => $ipAddress]);
        }
        $searchdata = 1;
        return view('frontend.all-product', compact('products', 'searchdata'));
    }

    public function prescriptionrequest(Request $request)
    {
        // Handle image upload
        if ($request->hasFile('img')) {
            // Get the file name with extension
            $fileNameWithExt = $request->file('img')->getClientOriginalName();
            // Get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('img')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            // Upload image to server's filesystem
            $path = $request->file('img')->move(public_path('frontend-asset/prescription_images'), $fileNameToStore);
            $path = 'frontend-asset/prescription_images/' . $fileNameToStore;
        }
        // Create a new PrescriptionRequest instance and store it in the database
        PrescriptionRequest::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'img' => $path,
            'status' => $request->status ?? 'pending', // Default status is 'pending' if not provided
        ]);
        // Pass the fetched data to the view
        return redirect()->back()->with('success', 'Prescription request submitted successfully.');
    }
    public function contactus()
    {
        return view('frontend.contactus');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'msg' => 'required|string',
        ]);

        // Process the form submission (e.g., save to database)
        ContactUs::create($request->all());

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    public function aboutus()
    {
        return view('frontend.aboutus');
    }
    public function returnpolicy()
    {
        return view('frontend.returnpolicy');
    }
    public function privacy()
    {
        return view('frontend.returnpolicy');
    }
    public function termcondition()
    {
        return view('frontend.returnpolicy');
    }
}
