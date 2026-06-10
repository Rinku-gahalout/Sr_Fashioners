<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BulkOrder extends Model
{
    use SoftDeletes;

    protected $table = 'bulk_orders';

    protected $fillable = [
        'order_id',
        'customer_id',
        'customer_name',
        'company_name',
        'mobile',

        'product_name',
        'product_description',
        'fabric',
        'color',
        'size_breakdown',

        'quantity',
        'unit_price',
        'advance_paid',
        'discount_amount',

        'delivery_date',
        'delivery_address',

        'status',

        'invoice_number',
        'gst_percent',

        'notes',
    ];

    protected $casts = [
        'quantity'         => 'integer',
        'unit_price'       => 'decimal:2',
        'total_amount'     => 'decimal:2',
        'advance_paid'     => 'decimal:2',
        'discount_amount'  => 'decimal:2',
        'gst_percent'      => 'decimal:2',
        'delivery_date'    => 'date',
        'size_breakdown'   => 'array', // JSON <=> Array
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
        'deleted_at'       => 'datetime',
    ];

    /**
     * Bulk Order belongs to Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Balance Amount
     */
    public function getBalanceAmountAttribute()
    {
        return $this->total_amount
             - $this->advance_paid
             - $this->discount_amount;
    }

    /**
     * GST Amount
     */
    public function getGstAmountAttribute()
    {
        return ($this->total_amount * $this->gst_percent) / 100;
    }

    /**
     * Grand Total
     */
    public function getGrandTotalAttribute()
    {
        return $this->total_amount
             - $this->discount_amount
             + $this->gst_amount;
    }
}
