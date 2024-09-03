<?php

namespace Dkvhin\LaravelModelHistories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModelHasHistory extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table =  config('model_histories.table')  ?: parent::getTable();
    }

    /**
     * @var array<string>
     */
    protected $fillable = [
        'description',
        'old_values',
        'new_values',
        'is_force_insert'
    ];

    /**
     * Cast Column to specific data type
     */
    protected $casts = [
        'old_values'    => 'array',
        'new_values'    => 'array'
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): MorphTo
    {
        return $this->morphTo()->withoutGlobalScope(SoftDeletingScope::class);
    }
}
