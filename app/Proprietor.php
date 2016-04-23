<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proprietor extends Model
{
    
    
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'nickname',
        'residence',
        'occupation',
        'differential',
        'comments'
    ];
    
    // public function relatedProprietors()
    // {
    //     return $this->belongsToMany('App\Proprietor', 'proprietor_relation', 'proprietor_id', 'related_proprietor_id')->withPivot('family_relation_id')->withTimestamps();
    // }
    
    public function relatedProprietors()
    {
        return $this->belongsToMany('App\Proprietor', 'proprietor_relation', 'proprietor_id', 'related_proprietor_id')
            ->join('family_relations', 'proprietor_relation.family_relation_id', '=', 'family_relations.id')
            ->addSelect('family_relations.name as family_relation')
            ->select('family_relations.name as family_relation', 'family_relations.id as family_relation_id', 'proprietors.*')
            ->withTimestamps();
    }
    
    public function getFieldDisplayAttribute()
    {
        $name = $this->name . ", " . $this->first_name . " " . $this->nickname . " (" . $this->occupation . ") " . $this->differential;
        return $name;
    }
}
