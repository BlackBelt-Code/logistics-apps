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

    public function order()
    {
        return $this->hasOne('App\Models\Order');
    }

    /*
        SCOPE
    */

    public function scopeCategoryGet($query)
    {
        return $query->select('*')->get();
    }

    /*
        SET ATTRIBUTE
     */


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ucfirst($value);
    }


    /*
        GET ATTRIBUTE
    */


    public function getCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->tz('Asia/Jakarta')->format('d/m/Y');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->tz('Asia/Jakarta')->format('d/m/Y');
    }
}
