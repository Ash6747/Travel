<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Stop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $routes = Route::all();
        // echo "<pre>";
        // print_r($routes->toArray());
        // echo "</pre>";
        $data = compact('routes');
        return view('admin.route.routes')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $url = 'route.store';
        $title = "Route Registration";
        $routTitle = "Register";
        $data = compact('url', 'title', 'routTitle');
        return view('admin.route.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'route_name' => ['required', 'string', 'max:50'],
            'start_location' => ['required', 'string', 'max:50'],
            'end_location' => ['required', 'string', 'max:50'],
        ]);

        // dd($request);
        $newRoute = new Route;
        $newRoute->route_name = $request['route_name'];
        $newRoute->start_location = $request['start_location'];
        $newRoute->end_location = $request['end_location'];

        $newRoute->save();
        return redirect()->route('route.table')->with('status', 'Route Registered Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the route along with its stops and their 'order' values
        $route = Route::with('stops')->findOrFail($id);

        // Get all available stops to populate the dropdown
        $stops = Stop::all();

        // Debugging (Optional)
        // dd($route->stops);

        // Prepare data for the view
        $data = compact('route', 'id', 'stops');
        return view('admin.route.stops')->with($data);
    }
    public function detach(string $id, string $stopId)
    {
        //
        // echo $id;
        // echo $stopId;
        // Step 2: Use Eloquent to check if the combination exists
        $route = Route::with('stops')->findOrFail($id);
        $route->stops()->detach($stopId);
        return redirect()
            ->route('route.stops', ['id' => $id])
            ->with('status', 'Stop detached from route successfully.');
        // $stops = Stop::all();
        // $route = Route::with('stops')->find($id);
        // // dd($route);
        // $data = compact('route', 'id', 'stops');
        // return view('admin.route.stops')->with($data);
    }

    public function sync(Request $request, string $id, string $stopId)
    {
        // Validate the stop_order input
        $validated = $request->validate([
            'stop_order'.$stopId => 'required|integer|min:1|max:99',
        ]);

        $order = $validated['stop_order'.$stopId];
        // $route_id = $id;

        // Step 2: Use Eloquent to check if the combination exists
        $route = Route::with('stops')->findOrFail($id);

        // Check if the 'order' already exists for this route
        if ($route->stops()->wherePivot('stop_order', $order)->exists()) {
            // Return with an error if the same order already exists for this route
            return redirect()
                ->route('route.stops', ['id' => $id])
                ->withErrors(['stop_order'.$stopId => 'This order number is already assigned to another stop on this route.']);
        }

        // Check if the stop is part of the route
        if (!$route->stops->contains($stopId)) {
            return redirect()
                ->back()
                ->withErrors(['stop_order' => 'This stop does not belong to the specified route.'])
                ->withInput();
        }

        // Sync the single stop's stop_order value in the pivot table
        $route->stops()->updateExistingPivot($stopId, ['stop_order' => $validated['stop_order'.$stopId]]);

        return redirect()
            ->route('route.stops', ['id' => $id])
            ->with('status', 'Stop order updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function add(Request $request, string $id)
    {
        // dd($request);
        // echo $id;

        // Step 1: Validate the request with 'stop_order' field and enhanced stop validation
        $validated = $request->validate([
            'stop' => ['required', 'exists:'.Stop::class.',id', 'not_in:0'],  // stop_id must exist and cannot be 0
            'stop_order'   => 'required|integer|min:1',  // Order must be a positive integer
        ]);

        $stop_id = $validated['stop'];
        $order = $validated['stop_order'];
        $route_id = $id;

        // Step 2: Use Eloquent to check if the combination exists
        $route = Route::with('stops')->findOrFail($route_id);

        // Check if the 'order' already exists for this route
        if ($route->stops()->wherePivot('stop_order', $order)->exists()) {
            // Return with an error if the same order already exists for this route
            return redirect()
                ->route('route.stops', ['id' => $id])
                ->withErrors(['stop_order' => 'This order number is already assigned to another stop on this route.']);
        }

        if ($route->stops()->where('stop_id', $stop_id)->exists()) {
            // If the combination exists, return with an error message
            return redirect()
                ->route('route.stops', ['id' => $id])
                ->withErrors(['stop' => 'This stop is already attached to the route.']);
        }

        // Step 3: Attach the stop to the route with 'order' value
        $route->stops()->attach($stop_id, ['stop_order' => $order]);

        // Step 4: Redirect back with a success message
        return redirect()
            ->route('route.stops', ['id' => $id])
            ->with('status', 'Stop attached to route successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // echo $id;
        $route = Route::find($id);
        // dd($route);
        if (is_null($route)) {
            return redirect('routes');
        } else {
            $url = 'route.update';
            $title = "Route Update";
            $routTitle = "Update";
            $data = compact('url', 'title', 'route', 'routTitle', 'id');
            return view('admin.route.form')->with($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Fetch the Admin model for the authenticated user
        $route = Route::find($id);

        $validatedData = $request->validate([
            'route_name' => ['required', 'string', 'max:50',
                            Rule::unique('routes', 'route_name')->ignore($id)],
            'start_location' => ['required', 'string', 'max:50'],
            'end_location' => ['required', 'string', 'max:50'],
        ]);
        // Using Eloquent's update method to update all fields at once
        $route->update($validatedData);
        // dd($validatedData);

        // Redirect back with a success message
        return redirect()->route('route.table')->with('status', 'Profile updated successfully.');
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
        $route = Route::find($id);
        // echo "<pre>";
        // print_r($route);
        if (is_null($route)) {
            return redirect()->route('route.table');
        } else {
            $route->status = !$route->status;
            $route->save();
            return redirect()->route('route.table');
        }
    }
}
