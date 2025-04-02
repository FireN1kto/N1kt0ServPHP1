<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';

    protected $fillable = ['name_role'];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}