<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyRelation extends Model
{
    
    public function getFieldDisplayAttribute()
    {
        $nameMasc = mb_convert_case($this->name_masc, MB_CASE_TITLE);
        $nameFem = mb_convert_case($this->name_fem, MB_CASE_TITLE);
        return $nameMasc . ' / ' . $nameFem;
    }
    
    public function getNameMascDisplayAttribute()
    {
        return mb_convert_case($this->name_masc, MB_CASE_TITLE);
    }
    
    public function getNameFemDisplayAttribute()
    {
        return mb_convert_case($this->name_fem, MB_CASE_TITLE);
    }
}
