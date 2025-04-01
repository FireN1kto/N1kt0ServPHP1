<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Position extends Model
{
    protected $table = 'hvpetxch_m5_position';

    protected $fillable = ['name_position'];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class, 'position_id');
    }
}