<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Model\User;
class CreatedInfo extends Model
{
    protected $table = 'created_info';

    public $timestamps = false;
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