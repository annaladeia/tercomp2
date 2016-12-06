<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyRelation extends Model
{
    
    public function getFieldDisplayAttribute()
    {
        $name = mb_convert_case($this->name_masc, MB_CASE_TITLE);
        $nameFem = mb_convert_case($this->name_fem, MB_CASE_TITLE);
        if ($name != $nameFem) {
            $name .= ' / ' . $nameFem;
        }
        return str_replace('(S)', '(s)', $name);
    }
    
    public function getNameMascDisplayAttribute()
    {
        return str_replace('(S)', '(s)', mb_convert_case($this->name_masc, MB_CASE_TITLE));
    }
    
    public function getNameFemDisplayAttribute()
    {
        return str_replace('(S)', '(s)', mb_convert_case($this->name_fem, MB_CASE_TITLE));
    }
}
