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
        'comments'
    ];
    
    public function parcelConnections()
    {
        return $this->hasMany('App\ParcelConnection')
                    ->withTimestamps();
    }
    
    public function getFieldDisplayAttribute()
    {
        $name = $this->name;
        return $name;
    }
}
