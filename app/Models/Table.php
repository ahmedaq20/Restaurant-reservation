<?php

namespace App\Models;

use App\Enums\TablesStatus;
use App\Enums\TableLocation;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['name','guest_number','status','location'];


    protected $casts =[
        'status' => TablesStatus::class,
        'location' => TableLocation::class,
    ];

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
  
 
}