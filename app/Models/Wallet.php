<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    protected $fillable =[
        'name',
        'balance',
        'currency',
        'type',
        'category_id'
    ];
    public function transactions():HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    /** @use HasFactory<\Database\Factories\WalletFactory> */
    use HasFactory;
    /**
     * Get the category that this wallet belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
