<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use App\Models\Driver;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's profile form.
     */
    public function showCompleteProfile(Request $request)
    {
        return view('profile.completeProfile', [
            'user' => $request->user(),
        ]);
    }

    public function completeProfile(Request $request,string $id)
    {
        // dd($request);
        $user = User::find($id);


        // dd($user);
        if($user->role == 'driver'){
             // Validate the request inputs
            $request->validate([
                'profile' => ['required', 'mimes:png,jpg,jpeg'],
                'license_file' => ['required', 'mimes:png,jpg,jpeg'],
                'firstName' => ['required', 'string', 'max:50'],
                'middleName' => ['required', 'string', 'max:50'],
                'lastName' => ['required', 'string', 'max:50'],
                'contact' => ['required', 'digits:10'], // digits validation for 10 numbers
                'whatsup_no' => ['required', 'digits:10'], // digits validation for 10 numbers
                'license_exp' => ['required', 'date'], // Only date validation
                'license_number' => ['required', 'digits:10'],
                'address' => ['required', 'string', 'max:255'],
                'pincode' => ['required', 'digits:6'], // Pincode with 6 digits
                'user_id' => ['required', 'exists:'.User::class.',id']//, 'unique:'.Driver::class.',user_id'], // Check if user exists and unique in drivers
            ], [
                'user_id.exists' => 'The selected user does not exist.',
                // 'user_id.unique' => 'This user already has a driver profile.',
            ]);
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
            return redirect()->route('driver.table');
        }elseif($user->role == 'student'){
            $request->validate([
                'profile' => ['required', 'mimes:png,jpg'],
                'prn' => ['required', 'string', 'max:25', 'unique:'.Student::class.',prn'],
                'firstName' => ['required', 'string', 'max:50'],
                'middleName' => ['required', 'string', 'max:50'],
                'lastName' => ['required', 'string', 'max:50'],
                'contact' => ['required', 'string', 'digits:10'],
                'whatsup_no' => ['required', 'string', 'digits:10'],
                'dob' => [
                            'required',
                            'date',
                            'before:' . now()->subYears(5)->format('Y-m-d'),   // Must be older than 5 years
                            'after:' . now()->subYears(90)->format('Y-m-d'),   // Must be younger than 90 years
                        ],
                'course' => ['required', 'string'],
                'year' => ['required', 'string'],
                'guardianFirstName' => ['required', 'string', 'max:50'],
                'guardianMiddleName' => ['required', 'string', 'max:50'],
                'guardianLastName' => ['required', 'string', 'max:50'],
                'guardianContact' => ['required', 'string', 'digits:10'],
                'address' => ['required', 'string', 'max:255'],
                'pincode' => ['required', 'string', 'digits:6'],
                'guardianEmail' => ['string', 'lowercase', 'email', 'max:255'],
                'user_id' => ['required', 'exists:'.User::class.',id', 'unique:'.Student::class.',user_id'], // Check if user exists and unique in drivers
            ], [
                'user_id.exists' => 'The selected user does not exist.',
                'user_id.unique' => 'This user already has a driver profile.',
            ]);
            $newUser = new Student;
            $newUser->prn = $request['prn'];
            $newUser->dob = $request['dob'];
            $newUser->course = $request['course'];
            $newUser->admission_year = $request['year'];
            $newUser->guardian_name = $request['guardianFirstName']." ".$request['guardianMiddleName']." ".$request['guardianLastName'];
            $newUser->guardian_email = $request['guardianEmail'];
            $newUser->guardian_contact = $request['guardianContact'];
            $newUser->address = $request['address'];
            $newUser->pincode = $request['pincode'];

        }elseif($user->role == 'guardian'){
            // $user = new Guardian;
        }elseif($user->role == 'admin'){
             // Validate the request inputs
             $request->validate([
                'profile' => ['required', 'mimes:png,jpg,jpeg'],
                'identity_file' => ['required', 'mimes:png,jpg,jpeg'],
                'firstName' => ['required', 'string', 'max:50'],
                'middleName' => ['required', 'string', 'max:50'],
                'lastName' => ['required', 'string', 'max:50'],
                'contact' => ['required', 'digits:10'], // digits validation for 10 numbers
                'whatsup_no' => ['required', 'digits:10'], // digits validation for 10 numbers
                'identity_number' => ['required', 'digits:10'],
                'user_id' => ['required', 'exists:'.User::class.',id', 'unique:'.Admin::class.',user_id'], // Check if user exists and unique in drivers
            ], [
                'user_id.exists' => 'The selected user does not exist.',
                'user_id.unique' => 'This user already has a driver profile.',
            ]);
            $newUser = new Admin;
            $newUser->identity_number = $request['identity_number'];
            $newUser->identity_file = $request->file('identity_file')->store('admin/identity', 'public');
        }
        $newUser->profile = $request->file('profile')->store($user->role.'/profile', 'public');
        $newUser->full_name = $request['firstName']." ".$request['middleName']." ".$request['lastName'];
        $newUser->contact = $request['contact'];
        $newUser->whatsup_no = $request['whatsup_no'];
        $newUser->user_id = $id;

        $newUser->save();
        return redirect($user->role.'/dashboard');
    }
}
