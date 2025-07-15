<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\StaffRole;

class Staff extends Model
{
    protected $fillable = [
    'name',
    'image',
    'email',
    'phone',
    'role',
    'hired_at',
    'notes',
    ];

     // Accessor for image URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        // Change the path to your default image in public folder
        return asset('images/default-image.png');
    }

    // protected $casts=[
    //     'role' => StaffRole::class,
    // ];

}