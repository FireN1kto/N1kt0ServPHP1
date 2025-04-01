<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Role extends Model
{
    protected $table = 'hvpetxch_m5_role';

    protected $fillable = [
        'admin',
        'registration_officer'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }
}