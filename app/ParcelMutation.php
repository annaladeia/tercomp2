<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParcelMutation extends Model
{
    
    
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'year',
        'month',
        'day',
        'share',
        'reason',
        'comments'
    ];
    
    public function parcel()
    {
        return $this->belongsTo('App\Parcel');
    }
    
    public function proprietors()
    {
        return $this->belongsToMany('App\Proprietor');
    }
    
    public function getProprietorIDsAttribute()
    {
        return $this->proprietors->pluck('id')->toArray();
    }
}
