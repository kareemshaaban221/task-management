<?php

namespace App\Models;

use App\Observers\TaskObserver;
use App\Traits\ModelSearch;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(TaskObserver::class)]
class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory,
        ModelSearch;

    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'user_id',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    /**
     * @param Builder $query
     * @param mixed $filters
     */
    public function scopeFilter($query, $filters)
    {
        $query
            ->when($filters['status'] ?? null, function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })
            ->when($filters['due_date_from'] ?? null, function ($query) use ($filters) {
                $query->where('due_date', '>=', $filters['due_date_from']);
            })
            ->when($filters['due_date_to'] ?? null, function ($query) use ($filters) {
                $query->where('due_date', '<=', $filters['due_date_to']);
            });
    }
}
