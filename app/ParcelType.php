<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParcelType extends Model
{
    
    
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'comments'
    ];
    
    public function parcels()
    {
        return $this->belongsToMany('App\Parcel')
                    ->withTimestamps();
    }
    
    public function getFieldDisplayAttribute()
    {
        $name = $this->name;
        return $name;
    }
}
