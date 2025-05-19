<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable=[
        'wallet_id',
        'category_id',
        'type',
        'amount',
        'description',
    ];
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
    
    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
