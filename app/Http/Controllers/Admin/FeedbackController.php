<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $feedbacks = Feedback::with(['student', 'bus'=> function($query){
            $query->with('route');
        }, 'driver', 'trip'])->get();
        // dd($bookings);
        // $status = 'pending';
        $data = compact('feedbacks');
        return view('admin.feedback.feedbacks')->with($data);
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
        $feedback = Feedback::with(['student', 'bus'=> function($query){
            $query->with('route');
        }, 'driver', 'trip'])->findOrFail($id);

        // dd($feedback);
        if (is_null($feedback)) {
            return redirect('feedbacks');
        } else {
            // $url = 'feedback.update';
            $title = "feedback Update";
            $routTitle = "Update";
            $data = compact('title', 'feedback', 'routTitle', 'id');
            return view('admin.feedback.form')->with($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
