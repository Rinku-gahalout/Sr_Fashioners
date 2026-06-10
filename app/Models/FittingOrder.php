<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FittingOrder extends Model
{
    use SoftDeletes;

    protected $table = 'fitting_orders';

    protected $fillable = [
        'order_id',
        'customer_id',
        'customer_name',
        'mobile',
        'product_name',
        'style',
        'product_description',
        'fabric',
        'color',
        'total_amount',
        'advance_paid',
        'delivery_date',
        'trial_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'total_amount'   => 'decimal:2',
        'advance_paid'   => 'decimal:2',
        'delivery_date'  => 'date',
        'trial_date'     => 'date',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
        'deleted_at'     => 'datetime',
    ];

    /**
     * Relationship: Order belongs to Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Accessor for balance amount
     * (useful even if DB has virtual column)
     */
    public function getBalanceAmountAttribute()
    {
        return $this->total_amount - $this->advance_paid;
    }
}
