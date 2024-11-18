<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TriphistoryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $triphistories;

    public function __construct($triphistories)
    {
        $this->triphistories = $triphistories;
    }

    // public function collection()
    // {
    //     return $this->triphistories->map(function ($trip) {
    //         return [
    //             'Driver Name' => $trip->driver->name ?? 'N/A',
    //             'Bus Name' => $trip->trip->bus->name ?? 'N/A',
    //             'Route Name' => $trip->trip->bus->route->name ?? 'N/A',
    //             'Phase' => $trip->phase == 1 ? 'Morning' : 'Evening',
    //             'Start Time' => $trip->created_at->format('Y-m-d H:i:s'),
    //         ];
    //     });
    // }

    // public function headings(): array
    // {
    //     return [
    //         'Driver Name',
    //         'Bus Name',
    //         'Route Name',
    //         'Phase',
    //         'Start Time',
    //     ];
    // }
    // protected $triphistories;
    // public function __construct($triphistories)
    // {
    //     $this->triphistories = $triphistories;
    // }
    public function collection()
    {
        //
        return $this->triphistories->map(function ($triphistory){
            return [
                'Driver Name'=>$triphistory->driver->full_name,
                'Driver License'=>$triphistory->driver->license_number,
                'Start Reading'=>$triphistory->start_meter_reading,
                'End Reading'=>$triphistory->end_meter_reading,
                'Start Time'=>$triphistory->created_at->format('Y-m-d H:i:s'),
                'End Time'=>$triphistory->updated_at->format('Y-m-d H:i:s'),
                'Last location latitude'=>$triphistory->latitude,
                'Last location longitude'=>$triphistory->longitude,
                'Distance Traveled'=>$triphistory->distance_traveled,
                'Phase'=>$triphistory->phase == 1 ? 'Morning' : 'Evening',
                'Route'=> $triphistory->trip->bus->route->route_name,
                'Bus No.'=>$triphistory->trip->bus->bus_no,
                'Status'=>$triphistory->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Driver Name',
            'Driver License',
            'Start Reading',
            'End Reading',
            'Start Time',
            'End Time',
            'Last location latitude',
            'Last location longitude',
            'Distance Traveled',
            'Phase',
            'Route',
            'Bus No.',
            'Status',
        ];
    }
}
