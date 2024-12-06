<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CancellationBookingExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $cancellations;

    public function __construct($cancellations)
    {
        $this->cancellations = $cancellations;
    }

    public function collection()
    {
        //
        return $this->cancellations->map(function($cancellation){
            return [
                'Student PRN' => $cancellation->student->prn,
                'Student Name' => $cancellation->student->full_name,

                'Student Class' => $cancellation->booking->class,
                'Accademic Year' => $cancellation->booking->current_academic_year,

                'Bus No' => $cancellation->bus->bus_no,

                'Route' => $cancellation->booking->bus->route->route_name,
                'Stop' => $cancellation->booking->stop->stop_name,

                'Duration' => $cancellation->booking->duration,
                'Start Date' => $cancellation->booking->start_date,
                'End Date' => $cancellation->booking->end_date,
                'Fee' => $cancellation->booking->fee,
                'Total Paid' => $cancellation->booking->total_amount,
                'Refund' => $cancellation->booking->refund ?? 0,
                'Payment Status' => $cancellation->booking->payment_status,

                'Reason' => $cancellation->reason,

                'Resolution' => $cancellation->resolution ?? "Not Resolved",
                'Verified By' => $cancellation->admin->full_name ?? "not verified",

                'Status' => $cancellation->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Student PRN',
            'Student Name',
            'Student Class',
            'Accademic Year',

            'Bus No',
            'Route',
            'Stop',

            'Duration',
            'Start Date',
            'End Date',
            'Fee',
            'Total Paid',
            'Refund',
            'Payment Status',

            'Reason',
            'Resolution',
            'Verified By',

            'Status',
        ];
    }
}
