<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{

   protected $table = 'languages';

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'abbr', 'name', 'direction','local','active'
    ];

    public function scopeActive($query){
        return $query->where('active',1);
    }

    public function getActive(){
        return $this->active == 1 ? "مفعل": "غير مفعل" ;
    }
}
