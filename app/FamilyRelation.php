<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyRelation extends Model
{
    
    public function getFieldDisplayAttribute()
    {
        //return ucfirst($this->name);
        return mb_convert_case($this->name, MB_CASE_TITLE);
    }
}
