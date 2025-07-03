<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable =['name','description','price','image'];

     // Accessor for image URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        // Change the path to your default image in public folder
        return asset('images/default-image.png');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}