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
        'institution',
        'name',
        'first_name',
        'nickname',
        'sex',
        'residence',
        'occupation',
        'differential',
        'comments',
        'page'
    ];
    
    public function parcels()
    {
        return $this->belongsToMany('App\Parcel');
    }
    
    public function parcelConnections()
    {
        return $this->hasMany('App\ParcelConnection')
                    ->withTimestamps();
    }
    
    public function relatedProprietors()
    {
        return $this->belongsToMany('App\Proprietor', 'proprietor_relation', 'proprietor_id', 'related_proprietor_id')
            ->join('family_relations', 'proprietor_relation.family_relation_id', '=', 'family_relations.id')
            //->addSelect('CONCAT(family_relations.name_masc, \' / \', family_relations.name_fem) as family_relation')
            ->select(\DB::raw('CONCAT(family_relations.name_masc, \' / \', family_relations.name_fem) as family_relation'), 'family_relations.id as family_relation_id', 'proprietors.*')
            ->withTimestamps();
    }
    
    public function inverseRelatedProprietors()
    {
        return $this->belongsToMany('App\Proprietor', 'proprietor_relation', 'related_proprietor_id', 'proprietor_id')
            ->join('family_relations', 'proprietor_relation.family_relation_id', '=', 'family_relations.id')
            //->addSelect('CONCAT(family_relations.name_masc, \' / \', family_relations.name_fem) as family_relation')
            ->select(\DB::raw('CONCAT(family_relations.name_masc, \' / \', family_relations.name_fem) as family_relation'), 'family_relations.opposite_id as family_relation_opposite_id', 'family_relations.id as family_relation_id', 'proprietors.*')
            ->withTimestamps();
    }
    
    public function getFieldDisplayAttribute()
    {
        $name = $this->name . ", " . $this->first_name;
        
        if ($this->nickname) {
            $name .= " " . $this->nickname;
        }
        
        if ($this->occupation) {
            $name .= " (" . $this->occupation . ")";
        }
        
        if ($this->differential) {
            $name .= " " . $this->differential;
        }
        return $name;
    }
}
