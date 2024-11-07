<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BusesExport;
use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Route;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;
use Maatwebsite\Excel\Facades\Excel;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $buses = Bus::with('route')->get();
        // dd($buses);
        // echo "<pre>";
        // print_r($buses->toArray());
        // echo "</pre>";
        $status = '';
        $data = compact('buses', 'status');
        return view('admin.bus.buses')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function enabled()
    {
        //
        $buses = Bus::where('status', 1)->with('route')->get();
        // dd($buses);
        // echo "<pre>";
        // print_r($buses->toArray());
        // echo "</pre>";
        $status = 1;
        $data = compact('buses', 'status');
        return view('admin.bus.buses')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function disabled()
    {
        //
        $buses = Bus::where('status', 0)->with('route')->get();
        // dd($buses);
        // echo "<pre>";
        // print_r($buses->toArray());
        // echo "</pre>";
        $status = 0;
        $data = compact('buses', 'status');
        return view('admin.bus.buses')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $routes = Route::where('status', 1)->get(['id', 'route_name']);
        $url = 'bus.store';
        $title = "Bus Registration";
        $routTitle = "Register";
        $data = compact('url', 'title', 'routTitle', 'routes');
        return view('admin.bus.form')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'bus_no' => ['required', 'string', 'max:50', 'unique:'.Bus::class.',bus_no'],
            'capacity' => ['required', 'string', 'max:50'],
            'route_id' => ['required', 'exists:'.Route::class.',id'],
        ]);

        // dd($request);
        $newRoute = new Bus;
        $newRoute->bus_no = $request['bus_no'];
        $newRoute->capacity = $request['capacity'];
        $newRoute->route_id = $request['route_id'];

        $newRoute->save();
        return redirect()->route('bus.table')->with('status', 'Route Registered Successfully');
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
        $bus = Bus::find($id);
        $routes = Route::where('status', 1)->get(['id', 'route_name']);
        // dd($route);
        if (is_null($bus)) {
            return redirect('routes');
        } else {
            $url = 'bus.update';
            $title = "Route Update";
            $routTitle = "Update";
            $data = compact('url', 'title', 'bus', 'routTitle', 'id', 'routes');
            return view('admin.bus.form')->with($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Fetch the Admin model for the authenticated user
        $bus = Bus::find($id);
        $validatedData = $request->validate([
            'bus_no' => ['required', 'string', 'max:50', 'unique:'.Bus::class.',bus_no,'.$bus->id],
            'capacity' => ['required', 'numeric', 'max:70'],
            'route_id' => ['required', 'exists:'.Route::class.',id'],
        ]);

        // Using Eloquent's update method to update all fields at once
        $bus->update($validatedData);
        // dd($validatedData);

        // Redirect back with a success message
        return redirect()->route('bus.table')->with('status', 'Bus updated successfully.');
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
        $bus = Bus::find($id);
        // echo "<pre>";
        // print_r($bus);
        if (is_null($bus)) {
            return redirect()->route('bus.table');
        } else {
            $bus->status = !$bus->status;
            $bus->save();
            return redirect()->route('bus.table');
        }
    }

    public function export(Request $request)
    {
        $today = Carbon::today();
        $status = $request->query('status');

        // Filter based on status
        $query = Bus::with(['route']);

        if ($status == 0) {
            $buses = $query->where('status', 0)->get();
        } elseif ($status == 1) {
            $buses = $query->where('status', 1)->get();
        } else {
            $buses = $query->get(); // Default to all tran$buses if no status is provided
        }

        return Excel::download(new BusesExport($buses), 'buses.xlsx');
    }
}
