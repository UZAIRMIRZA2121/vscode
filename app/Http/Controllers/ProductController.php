<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Endroid\QrCode\Builder\Builder;

class ProductController extends Controller
{
    // Display a listing of the products.
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // Show the form for creating a new product.
    public function create()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('admin.products.create', compact('products', 'categories'));
    }

    // Display a listing of soft deleted products.
    public function trash()
    {
        $products = Product::onlyTrashed()->get();
        return view('admin.products.trash', compact('products'));
    }

    // Restore a soft deleted product.
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('products.trash')->with('success', 'Product restored successfully.');
    }

    // Permanently Delete a product.
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();
        return redirect()->route('products.trash')->with('success', 'Product permanently deleted.');
    }

    // Store a newly created product in storage.


    public function store(Request $request)
    {
        // =========================
        // Related products
        // =========================
        $relatedProductIds = $request->related_product_id
            ? implode(',', $request->related_product_id)
            : null;

        // =========================
        // Image upload
        // =========================
        $path = 'noimage.jpg';

        if ($request->hasFile('img')) {

            $image = $request->file('img');
            $fileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();

            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

            $uploadPath = public_path('frontend-asset/product_images');

            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true);
            }

            $image->move($uploadPath, $fileNameToStore);

            $path = 'frontend-asset/product_images/' . $fileNameToStore;
        }

        // =========================
        // Multiple Images upload
        // =========================
        $imagesArray = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '_' . uniqid() . '.' . $extension;
                
                $uploadPath = public_path('frontend-asset/product_images');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true);
                }
                
                $image->move($uploadPath, $fileNameToStore);
                $imagesArray[] = 'frontend-asset/product_images/' . $fileNameToStore;
            }
        }

        // =========================
        // Create product
        // =========================
        $product = Product::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'pres' => $request->pres,
            'img' => $path,
            'qty' => $request->qty,
            'price' => $request->price,
            'discount' => $request->discount,
            'formula' => $request->formula,
            'category_id' => $request->category_id,
            'related_product_id' => $relatedProductIds,
            'images' => $imagesArray,
        ]);

        // =========================
        // QR CODE GENERATION
        // =========================
        $baseUrl = rtrim(env('APP_URL'), '/');
        $productUrl = $baseUrl . '/product/' . $product->id;

        $qrDir = public_path('frontend-asset/product_qr');

        if (!File::exists($qrDir)) {
            File::makeDirectory($qrDir, 0777, true);
        }

        $qrFileName = 'qr_' . $product->id . '.png';
        $qrFullPath = $qrDir . '/' . $qrFileName;

        $result = Builder::create()
            ->data($productUrl)
            ->size(300)
            ->margin(10)
            ->build();

        $result->saveToFile($qrFullPath);

        // Save QR path in DB
        $product->update([
            'qr_code' => 'frontend-asset/product_qr/' . $qrFileName
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully with QR code.');
    }



    // Display the specified product.
    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show', compact('product'));
    }

    // Show the form for editing the specified product.
    public function edit($id)
    {
        $product = Product::find($id);
        $products = Product::all();
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'products', 'categories'));
    }

    // Update the specified product in storage.
    public function update(Request $request, $id)
    {


        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->desc = $request->input('desc');
        $product->pres = $request->input('pres');
        // Update other fields similarly
        $product->qty = $request->input('qty');
        $product->price = $request->input('price');
        $product->discount = $request->input('discount');
        $product->formula = $request->input('formula');
        $product->category_id = $request->input('category_id');
        $inputValue = $request->input('related_product_id');
        $product->related_product_id = is_array($inputValue) ? implode(',', $inputValue) : NULL;

        // Update the image if a new one is uploaded
        if ($request->hasFile('img')) {
            // Handle image upload
            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('frontend-asset/product_images'), $imageName);
            $imagePath = 'frontend-asset/product_images/' . $imageName;
            $product->img = $imagePath;
        }

        // Update multiple images
        if ($request->hasFile('images')) {
            $imagesArray = [];
            foreach ($request->file('images') as $image) {
                $fileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '_' . uniqid() . '.' . $extension;
                
                $uploadPath = public_path('frontend-asset/product_images');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true);
                }
                
                $image->move($uploadPath, $fileNameToStore);
                $imagesArray[] = 'frontend-asset/product_images/' . $fileNameToStore;
            }
            
            $existingImages = $product->images ?? [];
            $product->images = array_merge($existingImages, $imagesArray);
        }
        // Save the updated product
        $product->save();
        return redirect()->route('products.index');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // =========================
        // Delete product (Soft Delete)
        // =========================
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }


    public function getByMainCategory($mainCategoryId)
    {
        dd(2);
    }

    public function search(Request $request)
    {
        // Get the query parameter from the request
        $query = $request->query('query');

        // Query the database for products matching the formula
        $products = Product::where('formula', 'LIKE', "%{$query}%")->get(['name', 'formula', 'id']);

        // Return the products as JSON response
        return response()->json($products);
    }
}
