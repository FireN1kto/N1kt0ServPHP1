<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
class Position extends Model
{
    protected $table = 'position';

    protected $fillable = ['name_position'];

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'position_id');
    }
}