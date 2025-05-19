<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'category_type', 
        'color'
    ];
    /**
     * Get the transactions associated with this category.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function wallets()
    {
    return $this->hasMany(Wallet::class);
    }
}
