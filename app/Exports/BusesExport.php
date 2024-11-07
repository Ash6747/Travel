<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BusesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $buses;

    public function __construct($buses)
    {
        $this->buses = $buses;
    }

    public function collection()
    {
        return $this->buses->map(function($bus) {
            return [
                'Bus No' => $bus->bus_no,
                'Bus Capacity' => $bus->capacity,
                'Bus Status' => $bus->status,
                'Route' => $bus->route->route_name,
                'Start Location' => $bus->route->start_location,
                'End Location' => $bus->route->end_location,
                'Route status' => $bus->route->status,

            ];
        });
    }

    public function headings(): array
    {
        return [
            'Bus No',
            'Bus Capacity',
            'Bus Status',

            'Route',
            'Start Location',
            'End Location',
            'Route status',
        ];
    }
}
