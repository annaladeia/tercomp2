<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    
    
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'comments',
        'type'
    ];
    
    public function document()
    {
        return $this->belongsTo('App\Document');
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
}
