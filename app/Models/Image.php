<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function getImageAttribute($value)
    {
        return $value ? url($value) : null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
