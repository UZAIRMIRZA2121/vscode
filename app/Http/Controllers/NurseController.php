<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nurse;
use App\Models\NurseHire;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NurseController extends Controller
{
    public function index()
    {
        $nurses = Nurse::all();

        return view('admin.nurses.index', compact('nurses'));
    }

    public function create()
    {
        return view('admin.nurses.create');
    }

    public function store(Request $request)
    {

        try {
            // Validate incoming request
            $validatedData = $request->validate([
                'name' => 'required',
                'qualification' => 'required',
                'type' => 'required',
                'gender' => 'required',
                'date_of_birth' => 'required|date',
                'phone' => 'required',
                'email' => 'required|email',
                'img' => 'required|image',
                'hourly_rate' => 'required|numeric',
                'experience_years' => 'required|numeric',
                'address' => 'required',
            ]);

            // Upload image
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
                $path = $request->file('img')->move(public_path('frontend-asset/nurse_images'), $fileNameToStore);
                $path = 'frontend-asset/nurse_images/' . $fileNameToStore;
            } else {
                $path = 'noimage.jpg'; // Placeholder image if no image is uploaded
            }

            // Create new Nurse instance and store in database
            $nurse = new Nurse();
            $nurse->name = $request->name;
            $nurse->qualification = $request->qualification;
            $nurse->type = $request->type;
            $nurse->gender = $request->gender;
            $nurse->date_of_birth = $request->date_of_birth;
            $nurse->phone = $request->phone;
            $nurse->email = $request->email;
            $nurse->img = $path;
            $nurse->hourly_rate = $request->hourly_rate;
            $nurse->experience_years = $request->experience_years;
            $nurse->specialization = $request->specialization;
            $nurse->address = $request->address;
            $nurse->desc = $request->desc;
            $nurse->save();
            return redirect()->route('nurses.index')->with('success', 'Nurse created successfully.');
        } catch (\Exception $e) {
            // Log the exception        
            dd($e->getMessage());
            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to create nurse. Please try again.');
        }
    }


    public function show($id)
    {
        $nurse = Nurse::findOrFail($id);
        return view('nurses.show', compact('nurse'));
    }

    public function edit($id)
    {
        $nurse = Nurse::findOrFail($id);
        return view('admin.nurses.edit', compact('nurse'));
    }

    public function update(Request $request, $id)
    {
        $nurse = Nurse::findOrFail($id);

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
            $path = $request->file('img')->move(public_path('frontend-asset/nurse_images'), $fileNameToStore);
            $path = 'frontend-asset/nurse_images/' . $fileNameToStore;

            // Update the nurse image path
            $nurse->img = $path;
        }

        // Update other nurse attributes
        $nurse->update($request->except('img'));

        return redirect()->route('nurses.index')->with('success', 'Nurse updated successfully.');
    }

    public function destroy($id)
    {
        $nurse = Nurse::findOrFail($id);
        $nurse->delete();
        return redirect()->route('nurses.index')->with('success', 'Nurse deleted successfully.');
    }


    public function toggleAvailability($id)
    {
        $nurse = Nurse::findOrFail($id);

        // Toggle the availability
        $nurse->availability = $nurse->availability == 1 ? 0 : 1;
        $nurse->save();

        return redirect()->back()->with('success', 'Availability changed successfully.');
    }

    public function hire($id)
    {
        // Check if the user has already sent a request for hiring the nurse
        $existingRequest = NurseHire::where('user_id', Auth::id())
            ->where('nurse_id', $id)
            ->where('status', 'requested')
            ->exists();

        // If a request already exists, redirect back with a message
        if ($existingRequest) {
            return redirect()->back()->with('error', 'Request already sent for hiring this Nurse.');
        }
        // Create a new NurseHire record
        $NurseHire = new NurseHire();
        $NurseHire->user_id = Auth::id(); // Assuming you are using authentication and storing the user ID who hires the nurse
        $NurseHire->nurse_id = $id; // Nurse ID passed from the route parameter
        $NurseHire->hire_date = now(); // Assuming you want to set the hire date as the current date

        // Save the NurseHire record
        $NurseHire->save();

        // Redirect or return a response
        return redirect()->back()->with('success', 'Request  sent for hiring this Nurse.');
    }

    public function nursesrequest()
    {
        // Check if the user has already sent a request for hiring the nurse
        $nurserequests = NurseHire::all();
        // Redirect or return a response
        return view('admin.nurses.request', compact('nurserequests'));
    }
    public function acceptRequest($id)
    {
        // Find the nurse by ID
        $nurse = NurseHire::findOrFail($id);

        // Update nurse status or perform any other actions
        $nurse->status = 'accepted';
        $nurse->start_time = Carbon::now();
        $nurse->save();

        // Redirect back or to any other route
        return redirect()->back()->with('success', 'Nurse request accepted successfully.');
    }

    public function rejectRequest($id)
    {
        // Find the nurse by ID
        $nurse = NurseHire::findOrFail($id);

        // Update nurse status or perform any other actions
        $nurse->status = 'rejected';
        $nurse->save();

        // Redirect back or to any other route
        return redirect()->back()->with('success', 'Nurse request rejected successfully.');
    }
    public function completeRequest($id)
    {
        // Find the nurse by ID
        $nurse = NurseHire::findOrFail($id);
        // Update nurse status or perform any other actions
        if ($nurse->status == 'accepted') {
            $nurse->status = 'completed';
            $nurse->end_time = Carbon::now();
            $nurse->save();
        }


        // Get hourly rate and start time
        $hourlyRate = $nurse->nurse->hourly_rate;
        $start = Carbon::parse($nurse->start_time);
        $end = Carbon::parse($nurse->end_time);
        $price = $nurse->nurse->hourly_rate;
        $duration = $end->diff($start);

        // Calculate the duration of the hire in seconds
        $durationInSeconds = $end->diffInSeconds($start);

        // Dump the duration in seconds
        // dd($durationInSeconds / 3600 * $price);
        $price = $durationInSeconds / 3600 * $price;
        $nurse->charge = $price;
        $nurse->save();
        // Redirect back or to any other route
        return redirect()->back()->with('success', 'Nurse dity completed successfully.');
    }

    public function commentRequest(Request $request, $id)
    {

        // Find the nurse by ID
        $nurse = NurseHire::findOrFail($id);
        // Check if the current status is "requested"
        if ($nurse->status === 'requested') {
            // Update the status to "removed"
            $nurse->status = 'removed';
            $nurse->save();
            return redirect()->back()->with('success', 'Nurse request deleted completed successfully.');
        } else {

            // Update the status to "terminate"
            $nurse->rating = $request->star;
            $nurse->comment = $request->comment;

            $nurse->status = 'terminate';
            $nurse->save();
            return redirect()->back()->with('success', 'Nurse duty completed successfully.');
        }

        // Save the changes


        // Redirect back or to any other route

    }

    public function nurse_hire_submit(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'nurse_id' => 'required|exists:nurses,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        // Update the authenticated user's information
        Auth::user()->update($validatedData);

        // Get the nurse ID from the form data
        $nurseId = $request->input('nurse_id');

        // Redirect to the nurse hire route with the nurse ID
        return redirect()->route('nurse.hire', ['id' => $nurseId])->with('success', 'Nurse hired successfully.');
    }
}
