<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ExpenseEstimation extends Model
{
    protected $fillable = [
        'money',
        'date',
        'description'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->user_id = Cache::get('auth')->id;
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
