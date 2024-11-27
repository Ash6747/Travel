<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // dd(Auth::user());
        $complaints = Complaint::with(['student', 'bus'=> function($query){
            $query->with('route');
        }, 'driver', 'trip'])->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $status = '';
        $data = compact('complaints', 'status');
        return view('admin.complaint.complaints')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function pending()
    {
        //
        $complaints = Complaint::with(['student', 'bus'=> function($query){
            $query->with('route');
        }, 'driver', 'trip'])->where('status', 'pending')->get();
        // dd($bookings);
        $status = 'pending';
        $data = compact('complaints', 'status');
        return view('admin.complaint.complaints')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function progress()
    {
        //
        $complaints = Complaint::with(['student', 'bus'=> function($query){
            $query->with('route');
        }, 'driver', 'trip'])->where('status', 'progress')->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $status = 'progress';
        $data = compact('complaints', 'status');
        return view('admin.complaint.complaints')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function resolved()
    {
        //
        $complaints = Complaint::with(['student', 'bus'=> function($query){
            $query->with('route');
        }, 'driver', 'trip'])->where('status', 'resolved')->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $status = 'resolved';
        $data = compact('complaints', 'status');
        return view('admin.complaint.complaints')->with($data);
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $complaint = Complaint::with(['student'=> function($query){
            $query->with(['user', 'course', 'bookings'=> function($query){
                $query->with(['stop', 'bus'=>function($query){
                    $query->with('route');
                }]);
            }]);
        }, 'bus'=> function($query){
            $query->with('route');
        },  'driver', 'trip', 'admin'])->findOrFail($id);

        // dd($route);
        if (is_null($complaint)) {
            return redirect('complaints');
        } else {
            $url = 'complaint.update';
            $title = "Complaint Update";
            $routTitle = "Update";
            $data = compact('url', 'title', 'complaint', 'routTitle', 'id');
            return view('admin.complaint.form')->with($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // dd($request);
        $user = Auth::user();
        $admin = User::with('admin')->findOrFail($user->id);
        $complaint = Complaint::findOrFail($id);
        // echo "<pre>";
        // print_r($bus);
        if (is_null($complaint)) {
            return redirect()->route('complaint.table')->with('error', "Can't find complaint");
        }

        if(!isset($admin->admin->id)){
            return redirect()->route('complaint.table', ['id'=>$id])->with('error', 'Admin Not exist');
        }

        // if($complaint)
        //Admin id for resolution
        $validatedData = $request->validate([
            'resolution' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',  // Allows alphabets, numbers, and spaces only
                'max:200',  // Optional: Limit resolution length
            ]
        ],[
            'resolution.regex'=> 'Allows alphabets, numbers, and spaces only',
        ]);

        $validatedData['verified_by'] = $admin->admin->id;
        $validatedData['status'] = 'resolved';
        $complaint->update($validatedData);

        // Return a response
        return redirect()->route('complaint.edit', ['id'=>$id])->with('status', 'Complaint Resolved with Solution');

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
    public function status(string $id)
    {
        $complaint = Complaint::findOrFail($id);
        // echo "<pre>";
        // print_r($bus);
        if (is_null($complaint)) {
            return redirect()->route('complaint.table')->with('error', "Can't find complaint");
        } else {
            $complaint->status = $complaint->status == 'pending' ? 'progress' : $complaint->status;
            $complaint->save();
            return redirect()->route('complaint.edit', ['id' => $complaint->id])->with('status', 'Complaint Is Now Ready To Resolve');
        }
    }
}
