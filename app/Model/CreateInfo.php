<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
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

    public function user()
    {
        return $this->belongTo(User::class, 'user_id');
    }
}