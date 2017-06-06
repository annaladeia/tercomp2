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
}
