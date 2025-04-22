<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Model\User;
class CreatedInfo extends Model
{
    protected $table = 'created_info';

    public $timestamps = false;
    protected $fillable = [
        'create_date',
        'user_id'
    ];

    protected $casts = [
        'create_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo('Model\User', 'user_id');
    }

    public function appointment()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}