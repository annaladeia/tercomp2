<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    
    
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'year',
        'type'
    ];
    
    public function parcels()
    {
        return $this->hasMany('App\Parcel');
    }
    
    public function proprietors()
    {
        return $this->hasMany('App\Proprietor');
    }
    
    public function places()
    {
        return $this->hasMany('App\Place');
    }
    
    public function references()
    {
        return $this->hasMany('App\Reference');
    }
    
    public function getFieldDisplayAttribute()
    {
        $name = $this->name;
        if ($name) $name .= ' - ';
        $name .= $this->year;
        return $name;
    }
}
