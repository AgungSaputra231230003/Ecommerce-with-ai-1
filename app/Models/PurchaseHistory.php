<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    protected $fillable = [
        'invoice',
        'user_id',
        'items',
        'total',
        'purchase_date',
    ];

    protected $casts = [
        'items' => 'array',
        'purchase_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
