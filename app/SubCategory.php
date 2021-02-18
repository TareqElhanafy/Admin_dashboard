<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'category_id', 'parent_id', 'trans_lang', 'trans_of',  'name',  'slug',  'photo',  'active'

    ];

    public function scopeActive($query)
    {
        return $query->where("active", 1);
    }

    public function getActive()
    {
        return $this->active == 1 ? "مفعل" : "غير مفعل ";
    }

    public function category()
    {
        return $this->belongsTo(MainCategory::class, 'category_id');
    }
}
