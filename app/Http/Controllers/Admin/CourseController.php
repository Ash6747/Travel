<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $courses = Course::all();
        // dd($courses);
        // echo "<pre>";
        // print_r($courses->toArray());
        // echo "</pre>";
        $data = compact('courses');
        return view('admin.course.courses')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $url = 'course.store';
        $title = "Course Registration";
        $routTitle = "Register";
        $data = compact('url', 'title', 'routTitle');
        return view('admin.course.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validate the incoming data
        $validatedData = $request->validate([
            'coures_full_name' => ['required','string', 'max:80', 'unique:'.Course::class.',coures_full_name'],
            'coures_short_name' => ['required','string', 'max:20', 'unique:'.Course::class.',coures_short_name'],
            'coures_code' => ['required','string', 'max:20', 'unique:'.Course::class.',coures_code'],
            'coures_years' => 'required|numeric|min:1|max:7',
        ]);

        // Save the data to the database
        Course::create($validatedData);

        return redirect()->route('course.table')->with('status', 'Course added successfully!');
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
        $course = Course::find($id);
        // dd($stop);
        if (is_null($course)) {
            return redirect('course');
        } else {
            $url = 'course.update';
            $title = "Course Update";
            $routTitle = "Update";
            $data = compact('url', 'title', 'course', 'routTitle', 'id');
            return view('admin.course.form')->with($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Fetch the Admin model for the authenticated user
        $course = Course::find($id);

        // Validate the incoming data
        $validatedData = $request->validate([
            'coures_full_name' => ['required','string', 'max:80',
                                Rule::unique('courses', 'coures_full_name')->ignore($course->id), // Ignore current course's ID
                            ],
            'coures_short_name' => ['required','string', 'max:20',
                                Rule::unique('courses', 'coures_short_name')->ignore($course->id), // Ignore current course's ID
                            ],
            'coures_code' => ['required','string', 'max:20',
                                Rule::unique('courses', 'coures_code')->ignore($course->id), // Ignore current stop's ID
                            ],
            'coures_years' => 'required|numeric|min:1',
        ]);

        // Using Eloquent's update method to update all fields at once
        $course->update($validatedData);
        // dd($validatedData);

        // Redirect back with a success message
        return redirect()->route('course.table')->with('status', 'Course updated successfully.');
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
        $course = Course::find($id);
        // echo "<pre>";
        // print_r($course);
        if (is_null($course)) {
            return redirect()->route('course.table');
        } else {
            $course->status = !$course->status;
            $course->save();
            return redirect()->route('course.table');
        }
    }
}
