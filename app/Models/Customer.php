<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'user_id',
        'customer_id',
        'name',
        'company_name',
        'mobile',
        'email',
        'city',
        'address',
        'pincode',
        'state',
        'type',
        'status',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Customer belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
