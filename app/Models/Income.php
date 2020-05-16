<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Income extends Model
{
    protected $fillable = [
        'money',
        'date',
        'description'
    ];
    /**
     * Boot Function, construct method in model
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($query) {
            $query->user_id = app('request')->auth->id;
        });
    }

    /**
     * Scope search query for Expense model
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  string $request
     * @param  array  $column
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, string $request, array $column): Builder
    {
        $result = $query;
        for ($i = 0; $i < count($column) ; $i++) {
            $result = $result->where($column[$i], 'LIKE', "%{$request}%");
        }
        return $result;
    }
    /**
     * Category Relation
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    /**
     * User Relation
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
