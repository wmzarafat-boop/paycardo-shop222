<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'subtitle', 'content',
        'meta_title', 'meta_description', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'active')
              ->orWhere('status', 1)
              ->orWhere('status', true);
        });
    }
}
