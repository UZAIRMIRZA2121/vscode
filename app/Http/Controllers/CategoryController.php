<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all(); 
         $miancategories = MainCategory::all();
        return view('admin.categories.index', compact('categories','miancategories'));
    }

    public function create()
    {
        return view('categories.create');
    }
    public function show($id)
    {

        $category = Category::findOrFail($id); // Retrieve the category data
        return view('admin.categories.show', compact('category'));
    }

    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',

        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

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
            $path = $request->file('img')->move(public_path('frontend-asset/category_images'), $fileNameToStore);
            $path = 'frontend-asset/category_images/' . $fileNameToStore;
        } else {
            $path = 'noimage.jpg'; // Placeholder image if no image is uploaded
        }

        // Create the category
        $category = new Category;
        $category->name = $request->input('name');
        $category->img = $path;
        $category->main_category_id = $request->main_category_id;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }
    public function edit(Category $category)
    {
        $maincategories = MainCategory::all();
        return view('admin.categories.edit', compact('category','maincategories'));
    }

    public function update(Request $request, Category $category)
    {
  
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Adjust the validation rules as needed
        ]);
        if ($request->hasFile('img')) {
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
                $path = $request->file('img')->move(public_path('frontend-asset/category_images'), $fileNameToStore);
                $img = 'frontend-asset/category_images/' . $fileNameToStore;
            } else {
                $img = 'noimage.jpg'; // Placeholder image if no image is uploaded
            }

            // Update the category with the validated data
            $category->update([
                'name' => $validatedData['name'],
                'img' => $img,
                'main_category_id' =>$request->main_category_id,
            ]);
        } else {
            $category->update([
                'name' => $validatedData['name'],
                'main_category_id' =>$request->main_category_id,
            ]);
        }
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }

    ///////Main--Categoeyies--Conroller---////////
    public function maincategories_index(Category $category)
    {
        $maincategories = MainCategory::all();
        return view('admin.maincategory.index', compact('maincategories'));
    }
    public function maincategories_store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',

        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // if ($request->hasFile('img')) {
        //     // Get the file name with extension
        //     $fileNameWithExt = $request->file('img')->getClientOriginalName();
        //     // Get just file name
        //     $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        //     // Get just extension
        //     $extension = $request->file('img')->getClientOriginalExtension();
        //     // Filename to store
        //     $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
        //     // Upload image to server's filesystem
        //     $path = $request->file('img')->move(public_path('frontend-asset/category_images'), $fileNameToStore);
        //     $path = 'frontend-asset/category_images/' . $fileNameToStore;
        // } else {
        //     $path = 'noimage.jpg'; // Placeholder image if no image is uploaded
        // }

        // Create the category
        $category = new MainCategory;
        $category->name = $request->input('name');
        // $category->img = $path;
        $category->save();

        return redirect()->route('maincategories.index')->with('success', 'Main Category created successfully');
    }

    public function maincategoryupdate(Request $request, MainCategory $category)
    {
        // Validate the incoming request data
        $request->validate([
            'categoryName' => 'required|string|max:255', // Adjust validation rules as needed
        ]);
    
        // Update the name of the main category
        $category->name = $request->input('categoryName');
        $category->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Main category updated successfully');
    }
    public function maincategorydestroy(MainCategory $category)
    {

        $category->delete();
        return redirect()->route('maincategories.index')->with('success', 'Category deleted successfully');
    }

}
