<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Driverleave;
use Illuminate\Http\Request;

class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaves = Driverleave::with('driver')
        ->orderBy('created_at', 'DESC')
        ->get();

        // dd($leaves);

        $data = compact('leaves');
        return view('admin.driver.leaveForm')->with($data);
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

    public function leavesStatus(Request $request, string $leaveId)
    {
        $leave = Driverleave::with('driver')
        ->findOrFail($leaveId);

        $leave['status'] = $request->query('status');
        // dd($leave);
        $leave->save();

        return redirect()->route('leave.table')->with('status', 'Driver leave '.$leave->status.' successfully!');
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
