<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class CreateInfo extends Model
{
    protected $table = 'create_info';
    protected $fillable = [
        'creation_date',
        'user_id'
    ];

    protected $casts = [
        'creation_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongTo(User::class, 'user_id');
    }
}