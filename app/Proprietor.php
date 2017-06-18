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
        'differential',
        'comments',
        'page'
    ];
    
    public function document()
    {
        return $this->belongsTo('App\Document');
    }
    
    public function parcels()
    {
        return $this->belongsToMany('App\Parcel');
    }
    
    public function professions()
    {
        return $this->belongsToMany('App\Profession', 'proprietor_profession');
    }
    
    public function parcelConnections()
    {
        return $this->belongsToMany('App\ParcelConnection')
                    ->withTimestamps();
    }
    
    public function relatedProprietors()
    {
        return $this->belongsToMany('App\Proprietor', 'proprietor_relation', 'proprietor_id', 'related_proprietor_id')
            ->join('family_relations', 'proprietor_relation.family_relation_id', '=', 'family_relations.id')
            ->select(\DB::raw('CONCAT(family_relations.name_masc, \' / \', family_relations.name_fem) as family_relation'), 'name_masc', 'name_fem', 'family_relations.id as family_relation_id', 'proprietors.*')
            ->withTimestamps();
    }
    
    public function inverseRelatedProprietors()
    {
        return $this->belongsToMany('App\Proprietor', 'proprietor_relation', 'related_proprietor_id', 'proprietor_id')
            ->join('family_relations', 'proprietor_relation.family_relation_id', '=', 'family_relations.id')
            ->select(\DB::raw('CONCAT(family_relations.name_masc, \' / \', family_relations.name_fem) as family_relation'), 'name_masc', 'name_fem', 'family_relations.opposite_id as family_relation_opposite_id', 'family_relations.id as family_relation_id', 'proprietors.*')
            ->withTimestamps();
    }
    
    public function getProfessionsDisplayAttribute()
    {
        $professions = [];
        foreach ($this->professions as $profession) {
            $professions[] = $profession['name'];
        }
        return implode(', ', $professions);
    }
    
    public function getFieldDisplayAttribute()
    {
        $name = $this->name;
        
        if ($this->first_name) {
            $name .= ", " . $this->first_name;
        }
        
        if ($this->nickname) {
            $name .= " " . $this->nickname;
        }
        
        if ($this->institution) {
            $name .= " " . $this->institution;
        }
        
        if ($this->differential) {
            $name .= " " . $this->differential;
        }
        
        if (trim(str_replace(',', '', str_replace(' ', '', $name))) == '') {
            $i = 0;
            foreach ($this->relatedProprietors as $relProprietor) {
                if ($i > 0) $name .= ' et ';
                switch ($relProprietor->sex) {
                    case 2:
                        $familyRelation = mb_convert_case($relProprietor->name_fem, MB_CASE_TITLE);
                        break;
                    default:
                        $familyRelation =  mb_convert_case($relProprietor->name_masc, MB_CASE_TITLE);
                        break;
                }
                $name .= str_replace('(S)', '(s)', $familyRelation) . ' de ' . $relProprietor->field_display;
                $i ++;
            }
        }
        
        if ($this->occupation) {
            $name .= " (" . $this->occupation . ")";
        }
        
        return trim($name);
    }
    
    public function getFieldExtendedDisplayAttribute()
    {
        $name = $this->name;
        
        if ($this->first_name) {
            $name .= ", " . $this->first_name;
        }
        
        if ($this->nickname) {
            $name .= " " . $this->nickname;
        }
        
        if ($this->institution) {
            $name .= " " . $this->institution;
        }
        
        if ($this->occupation) {
            $name .= " (" . $this->occupation . ")";
        }
        
        if ($this->differential) {
            $name .= " " . $this->differential;
        }
        
        $i = 0;
        foreach ($this->relatedProprietors as $relProprietor) {
            
            if ($i > 0)
                $name .= ' et ';
            elseif (trim($name) != '')
                $name .= " - ";
                
            switch ($relProprietor->sex) {
                case 2:
                    $familyRelation = mb_convert_case($relProprietor->name_fem, MB_CASE_TITLE);
                    break;
                default:
                    $familyRelation = mb_convert_case($relProprietor->name_masc, MB_CASE_TITLE);
                    break;
            }
            $name .= str_replace('(S)', '(s)', $familyRelation) . ' de ' . $relProprietor->field_display;
            $i ++;
        }
        
        return trim($name);
    }
}
