<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    
    
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'page_number',
        'front',
        'parcel_number',
        'arpent_input',
        'canne_input',
        'coup_input',
        'pugnerade_input',
        'seteree_input',
        'denier_input',
        'sous_input',
        'livre_input',
        'comments'
    ];
    
    public function document()
    {
        return $this->belongsTo('App\Document');
    }
    
    public function proprietors()
    {
        return $this->belongsToMany('App\Proprietor')
                    ->withTimestamps();
    }
    
    public function parcelMutations()
    {
        return $this->hasMany('App\ParcelMutation');
    }
    
    public function parcelTypes()
    {
        return $this->belongsToMany('App\ParcelType')
                    ->withTimestamps();
    }
    
    public function places()
    {
        return $this->belongsToMany('App\Place')
                    ->withTimestamps();
    }
    
    public function parcelConnections()
    {
        return $this->hasMany('App\ParcelConnection');
    }
    
    public function getFieldDisplayAttribute()
    {
        $name = $this->name;
        return $name;
    }
    
    public function getFieldUncertainAttribute()
    {
        $uncertain = false;
        
        foreach ($this->parcelConnections as $pc) {
            $uncertain = $uncertain || $pc->uncertain;
        }
        
        return $uncertain;
    }
}
