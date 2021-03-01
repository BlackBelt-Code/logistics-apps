<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function scopeCustomerGet($query) {
        return $query->select('*')->get();
    }
}
