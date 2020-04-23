<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = ['title'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getIconAttribute($value)
    {
        return $value ? url($value) : null;
    }

    public function getIconFilledAttribute($value)
    {
        return $value ? url($value) : null;
    }

    public function getImageAttribute($value)
    {
        return $value ? url($value) : null;
    }

    public function getTitleAttribute()
    {
        return $this->title_ar . ' - ' . $this->title_en;
    }
}
