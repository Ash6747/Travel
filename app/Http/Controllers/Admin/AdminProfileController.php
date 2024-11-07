<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Bus;
use App\Models\Course;
use App\Models\Driver;
use App\Models\Route;
use App\Models\Stop;
use App\Models\User;
use App\Models\User\loadRelatedModel;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::now()->toDateTimeString();  // Convert to a string in a valid SQL format

        // Count of expired and active bookings
        $bookingsExpiredCount = Booking::select(
            DB::raw("SUM(CASE WHEN end_date < '{$today}' THEN 1 ELSE 0 END) as expired_count"),
            DB::raw("SUM(CASE WHEN end_date > '{$today}' THEN 1 ELSE 0 END) as active_count")
        )
        ->where('status', 'approved')
        ->first();
        $totalBookingsExpiredCount = array_sum($bookingsExpiredCount->toArray());

        $bookingsCount = Booking::select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status');
        $totalBookingsCount = array_sum($bookingsCount->toArray());

        $busesCount = Bus::select('status', DB::raw('count(*) as count'))
                         ->groupBy('status')
                         ->pluck('count', 'status');
        // Calculate the total count by summing the results of each status count
        $totalBusesCount = array_sum($busesCount->toArray());

        $stopsCount = Stop::count();

        $routesCount = Route::select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status');
        $totalRoutesCount = array_sum($routesCount->toArray());

        $coursesCount = Course::select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status');
        $totalCoursesCount = array_sum($coursesCount->toArray());

        $registeredDrivers = Driver::select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->pluck('count', 'status');
        $totalRegisteredDrivers = array_sum($registeredDrivers->toArray());

        $unregisteredDrivers = User::where('role', 'driver')
        ->whereDoesntHave('driver')  // Ensure no relation in drivers table
        ->count();

        $data = compact(
            'bookingsExpiredCount',
            'totalBookingsExpiredCount',
            'bookingsCount',
            'totalBookingsCount',
            'busesCount',
            'totalBusesCount',
            'stopsCount',
            'routesCount',
            'totalRoutesCount',
            'coursesCount',
            'totalCoursesCount',
            'registeredDrivers',
            'totalRegisteredDrivers',
            'unregisteredDrivers'
        );
        return view('admin.dashboard')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::with('admin')->find($user_id);
        // dd($user);
        // Check if the user exists
        // if ($user) {
        //     // Call the loadRelatedModel method to get the corresponding related model
        //     $relatedModel = Auth::user()->loadRelatedModel();
        // }
        return view('admin.userProfile', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        // Fetch the Admin model for the authenticated user
        $admin = Admin::where('user_id', $user_id)->firstOrFail();

        // Validation of the request data
        $validatedData = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'digits_between:10,15', 'unique:' . Admin::class . ',contact,' . $admin->id], // Exclude current admin's contact
            'whatsup_no' => ['nullable', 'string', 'digits_between:10,15', 'unique:' . Admin::class . ',whatsup_no,' . $admin->id], // Same for whatsup_no
            'identity_number' => ['nullable', 'string', 'unique:' . Admin::class . ',identity_number,' . $admin->id], // Exclude current identity_number
            'identity_file' => ['nullable', 'mimes:jpg,png'],
            'profile' => ['nullable', 'mimes:jpg,png'],
        ]);

        // Handle file uploads (optional)
        if ($request->hasFile('profile')) {
            $profile_path = public_path('storage/') . $admin->profile;
            if (file_exists($profile_path)) {
                @unlink($profile_path);
            }
            $validatedData['profile'] = $request->file('profile')->store('admin/profile', 'public');
        }

        if ($request->hasFile('identity_file')) {
            $identity_path = public_path('storage/') . $admin->identity_file;
            if (file_exists($identity_path)) {
                @unlink($identity_path);
            }
            $validatedData['identity_file'] = $request->file('identity_file')->store('admin/identity', 'public');
        }

        // Using Eloquent's update method to update all fields at once
        $admin->update($validatedData);

        // Redirect back with a success message
        return redirect()->back()->with('status', 'Profile updated successfully.');
    }
}
