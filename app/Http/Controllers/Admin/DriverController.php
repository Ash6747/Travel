<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::all();
        // echo "<pre>";
        // print_r($drivers->toArray());
        // echo "</pre>";
        $data = compact('drivers');
        return view('admin.driver.drivers')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function unregistered()
    {
        // Query to get users with role 'driver' who do not exist in the drivers table
        // Order by 'created_at' to show the latest registrations first
        $drivers = User::where('role', 'driver')
        ->whereDoesntHave('driver')  // Ensure no relation in drivers table
        ->orderBy('created_at', 'desc')  // Newest users first
        ->get();

        // dd($drivers);
        $data = compact('drivers');
        return view('admin.driver.unregistered')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        // Check if the user's ID exists in the drivers table
        // $driver = Driver::where('user_id', $id)->first();

        // $data = compact('driver', 'id');
        // return view('admin.driver.form')->with($data);

        $url = 'driver.store';
        $title = "Driver Registration";
        $routTitle = "Register";
        $data = compact('url', 'title', 'routTitle', 'id');
        return view('admin.driver.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        // dd($request);
        $user = User::find($id);
        // Validate the request inputs

        $request->validate([
            'profile' => ['required', 'mimes:png,jpg,jpeg'],
            'license_file' => ['required', 'mimes:png,jpg,jpeg'],
            'firstName' => ['required', 'string', 'max:50'],
            'middleName' => ['required', 'string', 'max:50'],
            'lastName' => ['required', 'string', 'max:50'],
            'contact' => ['required', 'digits:10', 'unique:'.Driver::class.',contact'], // digits validation for 10 numbers
            'whatsup_no' => ['required', 'digits:10', 'unique:'.Driver::class.',whatsup_no'], // digits validation for 10 numbers
            'license_exp' => ['required', 'date'], // Only date validation
            'license_number' => ['required', 'string', 'max:10', 'unique:'.Driver::class.',license_number'],
            'address' => ['required', 'string', 'max:255'],
            'pincode' => ['required', 'digits:6'], // Pincode with 6 digits
            'user_id' => ['required', 'exists:'.User::class.',id', 'unique:'.Driver::class.',user_id'], // Check if user exists and unique in drivers
        ], [
            'user_id.exists' => 'The selected user does not exist.',
            'user_id.unique' => 'This user already has a driver profile.',
        ]);

        // dd($request);
        $newUser = new Driver;
        $newUser->license_number = $request['license_number'];
        $newUser->license_exp = $request['license_exp'];
        $newUser->address = $request['address'];
        $newUser->pincode = $request['pincode'];
        $newUser->license_file = $request->file('license_file')->store('driver/license', 'public');
        $newUser->profile = $request->file('profile')->store($user->role.'/profile', 'public');
        $newUser->full_name = $request['firstName']." ".$request['middleName']." ".$request['lastName'];
        $newUser->contact = $request['contact'];
        $newUser->whatsup_no = $request['whatsup_no'];
        $newUser->user_id = $id;

        $newUser->save();
        return redirect()->route('driver.unregistered')->with('status', 'Driver Registered Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $driver = Driver::find($id);
        // echo "<pre>";
        $driverName = explode(' ', $driver->full_name);
        // print_r($driverName);
        if (is_null($driver)) {
            return redirect('drivers');
        } else {
            $url = 'driver.update';
            $title = "Driver Update";
            $routTitle = "Update";
            $data = compact('url', 'title', 'driverName', 'driver', 'routTitle', 'id');
            return view('admin.driver.form')->with($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        // Validate the request inputs

        // Fetch the Admin model for the authenticated user
        $driver = Driver::find($id);
        // dd($driver);
        $request->validate([
            'firstName' => ['required', 'string', 'max:50'],
            'middleName' => ['required', 'string', 'max:50'],
            'lastName' => ['required', 'string', 'max:50'],
        ]);
        // Validation of the request data
        $validatedData = $request->validate([
            'contact' => ['required', 'string', 'digits_between:10,15', 'unique:' . Driver::class . ',contact,' . $driver->id], // Exclude current admin's contact
            'whatsup_no' => ['nullable', 'string', 'digits_between:10,15', 'unique:' . Driver::class . ',whatsup_no,' . $driver->id], // Same for whatsup_no
            'license_number' => ['nullable', 'string', 'unique:' . Driver::class . ',license_number,' . $driver->id], // Exclude current identity_number
            'license_exp' => ['required', 'date'], // Only date validation
            'license_file' => ['nullable', 'mimes:jpg,png'],
            'profile' => ['nullable', 'mimes:jpg,png'],
            'address' => ['required', 'string', 'max:255'],
            'pincode' => ['required', 'digits:6'], // Pincode with 6 digits
        ]);

        // Handle file uploads (optional)
        if ($request->hasFile('profile')) {
            $profile_path = public_path('storage/') . $driver->profile;
            if (file_exists($profile_path)) {
                @unlink($profile_path);
            }
            $validatedData['profile'] = $request->file('profile')->store($user->role.'/profile', 'public');
        }

        if ($request->hasFile('license_file')) {
            $license_path = public_path('storage/') . $driver->license_file;
            if (file_exists($license_path)) {
                @unlink($license_path);
            }
            $validatedData['license_file'] = $request->file('license_file')->store($user->role.'/identity', 'public');
        }

        $validatedData['full_name'] =  $request['firstName']." ".$request['middleName']." ".$request['lastName'];

        // Using Eloquent's update method to update all fields at once
        $driver->update($validatedData);
        // dd($validatedData);

        // Redirect back with a success message
        return redirect()->route('driver.table')->with('status', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Update the status in table.
     */
    public function active(string $id)
    {
        $driver = Driver::find($id);
        // echo "<pre>";
        // print_r($driver);
        if (is_null($driver)) {
            return redirect()->route('driver.table');
        } else {
            $driver->status = !$driver->status;
            $driver->save();
            return redirect()->route('driver.table');
        }
    }
}
