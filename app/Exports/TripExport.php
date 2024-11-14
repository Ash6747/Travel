<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TripExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $trips;
    public function __construct($trips)
    {
        $this->trips = $trips;
    }
    public function collection()
    {
        //
        return $this->trips->map(function ($trip){
            return [
                'Driver Name'=>$trip->driver->full_name,
                'Driver License'=>$trip->driver->license_number,
                'Morning Start Time'=>$trip->expected_morning_start_time,
                'Morning End Time'=>$trip->expected_morning_end_time,
                'Evening Start Time'=>$trip->expected_evening_start_time,
                'Evening End Time'=>$trip->expected_evening_end_time,
                'Distance'=>$trip->expected_distance,
                'Route'=> $trip->bus->route->route_name,
                'Bus No.'=>$trip->bus->bus_no,
                'Status'=>$trip->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Driver Name',
            'Driver License',
            'Morning Start Time',
            'Morning End Time',
            'Evening Start Time',
            'Evening End Time',
            'Distance',
            'Route',
            'Bus No.',
            'Status',
        ];
    }
}
