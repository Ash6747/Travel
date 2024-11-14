<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::guard('api')->user();
        $userDetails = User::with(['student'=>function($query){
            $query->with('transactions');
        }])->findOrFail($user->id);
        $transactions = $userDetails->student->transactions;

        if(isset($transactions)){
            return response()->json([
                'status'=> false,
                'message'=> 'Transactions for students',
                'trasactions'=> $transactions
            ]);
        }

        return response()->json([
            'status'=> false,
            'message'=> 'Transactions not exist for student'
        ]);

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
        // Get today's date
        // dd($request);
        $today = Carbon::today()->format('Y-m-d');

        // Define custom validation logic
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'booking_id' => 'required|exists:bookings,id',
            'payment_date' => "required|date|before_or_equal:$today", // Ensure payment date is today or earlier
            'reciept_token' => [
                'required',
                'string',
                'max:15',
                // Custom rule to ensure unique reciept_token for pending or accepted transactions
                function ($attribute, $value, $fail) {
                    $exists = Transaction::where('reciept_token', $value)
                        ->whereIn('status', ['pending', 'accepted'])
                        ->exists();

                    if ($exists) {
                        $fail('The receipt token must be unique for pending or accepted transactions.');
                    }
                }
            ],
            'paid_amount' => 'required|numeric|min:1|max:'.$request->booking_fee,
            'reciept_file' => 'required|mimes:png,jpg',
            'pay_type' => 'required|in:dd,cash,cheque,nft,upi,bank transfer',
            'paid_status' => 'required|in:full,partial',
        ]);

        // Handle file uploads (optional)

        // Store receipt file
        $recieptPath = $request->file('reciept_file')->store('student/reciepts', 'public');

        // Handle validation failure
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Proceed with transaction creation
        // Add receipt path to validated data
        $validatedData = $validator->validated();
        $validatedData['reciept_file'] = $recieptPath;

        // dd($validatedData);
        // Save the transaction (example)
        Transaction::create($validatedData);

        return response()
        ->json([
            'status'=> true,
            'message' => 'Transaction created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = Auth::guard('api')->user();
        // $userDetails = User::with(['student'=>function($query){
        //     $query->with(['transactions'=> function($query, $id){
        //         $query->findOrFail($id);
        //     }]);
        // }])->findOrFail($user->id);
        $userDetails = User::with(['student'=>function($query){
            $query->with(['transactions']);
        }])->findOrFail($user->id);

        try {
            $transaction = $userDetails->student->transactions->findOrFail($id);

            if(isset($transaction)){
                return response()->json([
                    'status'=> false,
                    'message'=> 'Transaction for students',
                    'trasaction'=> $transaction
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status'=> false,
                'message'=> 'Transaction not exist for student'
            ]);
        }

        // return response()->json([
        //     'status'=> false,
        //     'message'=> 'Transaction not exist for student'
        // ]);
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
