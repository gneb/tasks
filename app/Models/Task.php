<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'assignee_id',
    ];

    protected $casts = [
        'status' => TaskStatusEnum::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}
