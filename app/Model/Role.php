<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Role extends Model
{
    protected $table = 'role';

    protected $fillable = ['name_role'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }
}