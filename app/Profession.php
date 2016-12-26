<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
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
        return $this->belongsToMany('App\Proprietor', 'proprietor_profession')
                    ->withTimestamps();
    }
    
    public function getFieldDisplayAttribute()
    {
        $name = $this->name;
        return $name;
    }
}
