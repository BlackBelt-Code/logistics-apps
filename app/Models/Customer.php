<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Customer extends Model
{

    protected $tables = 'customers';

    protected $guarded = [];

    protected $fillable = [
        'name',
        'phone_number',
        'address',
        'point',
        'deposit'
    ];

    protected $rules = [
        'name' => 'unique:customers, name'
    ];

    public function getCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->tz('Asia/Jakarta')->format('d/m/Y');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->tz('Asia/Jakarta')->format('d/m/Y');
    }

    public function scopeCustomerGet($query) {
        return $query->select('*')->get();
    }
}
