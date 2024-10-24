<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $table = "routes";
    protected $primaryKey = "id";

    // A route can have many buses
    public function buses()
    {
        return $this->hasMany(Bus::class, 'route_id');
    }

    public function stops(){
        return $this->belongsToMany(Stop::class, 'route_stops')
        ->withPivot('stop_order')  // Include the 'order' column from pivot table
        ->orderBy('stop_order');  // Sort by the 'order' column
    }

    // Add the fields that you want to allow mass assignment for
    protected $fillable = [
        'route_name',
        'start_location',
        'end_location',
    ];
}
