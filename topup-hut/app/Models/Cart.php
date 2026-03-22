<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'session_id', 'product_id', 'variant_id', 'quantity', 'user_id_field'
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function getPriceAttribute()
    {
        if ($this->variant) {
            return $this->variant->current_price;
        }
        return $this->product->current_price;
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function getNameAttribute()
    {
        $name = $this->product->name;
        if ($this->variant) {
            $name .= ' - ' . $this->variant->name;
        }
        return $name;
    }

    public function getImageAttribute()
    {
        if ($this->variant && $this->variant->product->primaryImage) {
            return $this->variant->product->primaryImage->url;
        }
        if ($this->product->primaryImage) {
            return $this->product->primaryImage->url;
        }
        return asset('img/no-image.png');
    }
}
