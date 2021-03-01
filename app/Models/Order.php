<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{

    // protected $tables = 'orders';

    protected $guarded = [];

    protected $fillable = [
        'tracking_number',
        // 'customer_id',
        'sender_name',
        'sender_phone',
        'sender_address',
        'delivery_name',
        'delivery_phone',
        'delivery_address',
        // 'category_id',
        'shipping_cost',
        'item_price',
        'is_insurance',
        // 'user_id',
        'user_fee',
        'note',
        'shipping_photo',
        'delivered_photo',
        'status',
    ];

    protected $rules = [
        'name' => 'unique:customers, name'
    ];

    /**
     * ELEQUENT
     */

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    /**
     * SCOPE
     */


    public function scopeCustomerGet($query)
    {
        return $query->select('*')->get();
    }

    /**
     * GET ATTRIBUTE
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
