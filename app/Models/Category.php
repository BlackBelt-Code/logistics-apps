<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Category extends Model
{

    protected $tables = 'categories';

    protected $guarded = [];

    protected $fillable = [
        'name',
        'description',
    ];

    protected $rules = [
        'name' => 'unique:categories, name'
    ];

    public function setCreatedAt($value)
    {
        $this->attributes['created_at'] = (new Carbon($value))->format('d/m/y');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->tz('Asia/Jakarta')->format('d/m/Y');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->tz('Asia/Jakarta')->format('d/m/Y');
    }

    public function scopeCategoryGet($query)
    {
        return $query->select('*')->get();
    }
}
