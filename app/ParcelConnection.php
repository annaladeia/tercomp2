<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParcelConnection extends Model
{
    
    
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'page_number',
        'orientation',
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
    
    public function reference()
    {
        return $this->belongsTo('App\Reference');
    }
}
