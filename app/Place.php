<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    
    
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'color',
        'comments'
    ];
    
    public function document()
    {
        return $this->belongsTo('App\Document');
    }
    
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
