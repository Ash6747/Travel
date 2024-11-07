<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions->map(function($transaction) {
            return [
                'Payment Date' => $transaction->payment_date,
                'Reciept Token' => $transaction->reciept_token,
                'Paid Amount' => $transaction->paid_amount,
                'Pay Type' => $transaction->pay_type,
                'Status' => $transaction->status,
                'Paid Status' => $transaction->paid_status,
                'Payment Date Check' => $transaction->payment_date_check,
                'Reciept Token Check' => $transaction->reciept_token_check,
                'Paid Amound Check' => $transaction->paid_amount_check,
                'Reciept File Check' => $transaction->reciept_file_check,
                'Pay Type Check' => $transaction->pay_type_check,
                'Student Detail Check' => $transaction->student_detail_check,
                'Comment' => $transaction->comment,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Payment Date',
            'Reciept Token',
            'Paid Amount',
            'Pay Type',
            'Status',
            'Paid Status',
            'Payment Date Check',
            'Reciept Token Check',
            'Paid Amound Check',
            'Reciept File Check',
            'Pay Type Check',
            'Student Detail Check',
            'Comment',
        ];
    }
}
