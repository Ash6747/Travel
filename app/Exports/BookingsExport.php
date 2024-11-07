<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $bookings;

    public function __construct($bookings)
    {
        $this->bookings = $bookings;
    }

    public function collection()
    {
        return $this->bookings->map(function($booking) {
            return [
                'Student PRN' => $booking->student->prn,
                'Student Name' => $booking->student->full_name,
                'Student Class' => $booking->class,
                'Bus No' => $booking->bus->bus_no,
                'Accademic Year' => $booking->current_academic_year,
                'Route' => $booking->bus->route->route_name,
                'Stop' => $booking->stop->stop_name,
                'Duration' => $booking->duration,
                'Start Date' => $booking->start_date,
                'End Date' => $booking->end_date,
                'Fee' => $booking->fee,
                'Total Paid' => $booking->total_amount,
                'Refund' => $booking->refund,
                'Payment Status' => $booking->payment_status,
                'Status' => $booking->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Student PRN',
            'Student Name',
            'Student Class',
            'Bus No',
            'Accademic Year',
            'Route',
            'Stop',
            'Duration',
            'Start Date',
            'End Date',
            'Fee',
            'Total Paid',
            'Refund',
            'Payment Status',
            'Status',
        ];
    }
}
