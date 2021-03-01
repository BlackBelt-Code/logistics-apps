<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function scopeCategoryGet($query) {
        return $query->select('*')->get();
    }
}
