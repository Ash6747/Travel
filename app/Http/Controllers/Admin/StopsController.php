<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stop;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StopsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $stops = Stop::all();
        // dd($stops);
        // echo "<pre>";
        // print_r($stops->toArray());
        // echo "</pre>";
        $data = compact('stops');
        return view('admin.stop.stops')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $url = 'stop.store';
        $title = "Stop Registration";
        $routTitle = "Register";
        $data = compact('url', 'title', 'routTitle');
        return view('admin.stop.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validate the incoming data
        $validatedData = $request->validate([
            'stop_name' => ['required','string', 'max:100', 'unique:'.Stop::class.',stop_name'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'fee' => 'required|numeric|min:0',
        ]);

        // Save the data to the database
        Stop::create($validatedData);

        return redirect()->route('stop.table')->with('status', 'Stop added successfully!');
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
        $stop = Stop::find($id);
        // dd($stop);
        if (is_null($stop)) {
            return redirect('stops');
        } else {
            $url = 'stop.update';
            $title = "Stop Update";
            $routTitle = "Update";
            $data = compact('url', 'title', 'stop', 'routTitle', 'id');
            return view('admin.stop.form')->with($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Fetch the Admin model for the authenticated user
        $stop = Stop::find($id);

        // Validate the incoming data
        $validatedData = $request->validate([
            'stop_name' => ['required','string', 'max:100',
                                Rule::unique('stops', 'stop_name')->ignore($stop->id), // Ignore current stop's ID
                            ],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'fee' => 'required|numeric|min:0',
        ]);

        // Using Eloquent's update method to update all fields at once
        $stop->update($validatedData);
        // dd($validatedData);

        // Redirect back with a success message
        return redirect()->route('stop.table')->with('status', 'Stop updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
