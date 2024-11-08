<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TransactionsExport;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Transaction;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $transactions = Transaction::with(['student', 'booking'])
        ->orderBy('created_at', 'desc')
        ->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $status = '';
        $data = compact('transactions', 'status');
        return view('admin.transaction.transactions')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function pending()
    {
        //
        $transactions = Transaction::with(['student', 'booking'])
        ->where('status', 'pending')
        ->orderBy('created_at', 'desc')
        ->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $status = 'pending';
        $data = compact('transactions', 'status');
        return view('admin.transaction.transactions')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function accepted()
    {
        //
        $transactions = Transaction::with(['student', 'booking'])
        ->where('status', 'accepted')
        ->orderBy('created_at', 'desc')
        ->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $status = 'accepted';
        $data = compact('transactions', 'status');
        return view('admin.transaction.transactions')->with($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function rejected()
    {
        //
        $transactions = Transaction::with(['student', 'booking'])
        ->where('status', 'rejected')
        ->orderBy('created_at', 'desc')
        ->get();
        // dd($bookings);
        // echo "<pre>";
        // print_r($bookings->toArray());
        // echo "</pre>";
        $status = 'rejected';
        $data = compact('transactions', 'status');
        return view('admin.transaction.transactions')->with($data);
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
        $transaction = Transaction::with(['student', 'admin', 'booking'=>function($bookQuery){
            $bookQuery->with(['bus'=>function($busQuery){
                $busQuery->with('route');
            }, 'stop']);
        }])
        ->findOrFail($id);

        // dd($transaction);
        if (is_null($transaction)) {
            return redirect('bookings');
        } else {
            $url = 'transaction.update';
            $title = "Transaction Update";
            $routTitle = "Update";
            $data = compact('url', 'title', 'transaction', 'routTitle', 'id');
            return view('admin.transaction.form')->with($data);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // dd($request);
        // Retrieve the transaction with the related booking
        $transaction = Transaction::with('booking')->findOrFail($id);
        $user = Auth::user();
        $admin = User::with('admin')->findOrFail($user->id);

        if(!isset($admin->admin->id)){
            return redirect()->route('transaction.edit', ['id'=>$id])->with('error', 'Admin Not exist');
        }
        //Admin id for comment
        $validatedData = $request->validate([
            'comment' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9\s]+$/',  // Allows alphabets, numbers, and spaces only
                'max:200',  // Optional: Limit comment length
            ]
        ],[
            'comment.regex'=> 'Allows alphabets, numbers, and spaces only',
        ]);

        // Check if all required fields are 1
        $allChecksPassed = (
            $request->alluserDetailsCheck == 1 &&
            $request->payment_date_check == 1 &&
            $request->reciept_token_check == 1 &&
            $request->paid_amount_check == 1 &&
            $request->pay_type_check == 1 &&
            $request->reciept_file_check == 1
        );

        // Update transaction checks
        $transaction->student_detail_check = $request->alluserDetailsCheck ? '1' : '0';
        $transaction->payment_date_check = $request->payment_date_check ? '1' : '0';
        $transaction->reciept_token_check = $request->reciept_token_check ? '1' : '0';
        $transaction->paid_amount_check = $request->paid_amount_check ? '1' : '0';
        $transaction->pay_type_check = $request->pay_type_check ? '1' : '0';
        $transaction->reciept_file_check = $request->reciept_file_check ? '1' : '0';

        // Set status based on the checks
        $transaction->status = $allChecksPassed ? 'accepted' : 'rejected';
        $transaction->comment = $request->comment;
        $transaction->verified_by = $admin->admin->id;

        // Update booking total amount and payment status if transaction is accepted
        if ($transaction->status === 'accepted') {
            $transaction->booking->total_amount += $transaction->paid_amount;

            if($transaction->booking->total_amount > $transaction->booking->fee){
                return redirect()->route('transaction.edit', ['id'=>$id])->with('error', 'Transaction is getting over Paid reject transaction');
            }
            // Determine if the payment is partial or full
            $transaction->booking->payment_status =
                $transaction->booking->total_amount < $transaction->booking->fee ? 'Partially' : 'Full';

            // Save the booking update
            $transaction->booking->save();
        }

        // Save the updated transaction
        $transaction->save();

        // Return a response
        return redirect()->route('transaction.edit', ['id'=>$id])->with('status', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export(Request $request)
    {
        $today = Carbon::today();
        $status = $request->query('status');

        // Filter based on status
        $query = Transaction::with(['student', 'booking']);

        if ($status === 'pending') {
            $transactions = $query->where('status', 'pending')->get();
        } elseif ($status === 'accepted') {
            $transactions = $query->where('status', 'accepted')->get();
        } elseif ($status === 'rejected') {
            $transactions = $query->where('status', 'rejected')->get();
        } else {
            $transactions = $query->get(); // Default to all tran$transactions if no status is provided
        }

        return Excel::download(new TransactionsExport($transactions), 'transactions.xlsx');
    }

    public function pdf(string $id){

        $transaction = Transaction::with(['student', 'admin', 'booking'=>function($bookQuery){
            $bookQuery->with(['bus'=>function($busQuery){
                $busQuery->with('route');
            }, 'stop']);
        }])
        ->findOrFail($id);

        $url = 'transaction.update';
            $title = "Transaction";
            $routTitle = "Update";
            $data = compact('url', 'title', 'transaction', 'routTitle', 'id');
            // resources\views\admin\transaction\transactionPdf.blade.php
        $pdf = Pdf::loadView('admin.transaction.transactionPdf', $data);
        return $pdf->download('invoice.pdf');
    }
}
