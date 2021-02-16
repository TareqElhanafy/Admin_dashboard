<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'address', 'active', 'category_id', 'mobile', 'logo'
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    public function getActive()
    {
        return $this->active == 1 ? 'مفعل' : 'غير مفعل';
    }

    public function category()
    {
        return $this->belongsTo(MainCategory::class, 'category_id');
    }
}
