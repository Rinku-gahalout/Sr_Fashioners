<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measurement extends Model
{
        use SoftDeletes;

    protected $table = 'measurements';

    protected $fillable = [
        'fitting_order_id',

        // Upper Body
        'chest',
        'waist',
        'hips',
        'shoulder',
        'neck',

        // Shirt / Kurta
        'shirt_length',
        'sleeve_length',
        'sleeve_width',
        'wrist',

        // Lower Body
        'pant_length',
        'inseam',
        'thigh',
        'knee',
        'ankle',
        'rise',

        // Other
        'unit',
        'notes',
    ];

    protected $casts = [
        'chest'          => 'decimal:1',
        'waist'          => 'decimal:1',
        'hips'           => 'decimal:1',
        'shoulder'       => 'decimal:1',
        'neck'           => 'decimal:1',
        'shirt_length'   => 'decimal:1',
        'sleeve_length'  => 'decimal:1',
        'sleeve_width'   => 'decimal:1',
        'wrist'          => 'decimal:1',
        'pant_length'    => 'decimal:1',
        'inseam'         => 'decimal:1',
        'thigh'          => 'decimal:1',
        'knee'           => 'decimal:1',
        'ankle'          => 'decimal:1',
        'rise'           => 'decimal:1',
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
        'deleted_at'     => 'datetime',
    ];

    /**
     * Measurement belongs to a fitting order.
     */
    public function fittingOrder()
    {
        return $this->belongsTo(FittingOrder::class);
    }
}
