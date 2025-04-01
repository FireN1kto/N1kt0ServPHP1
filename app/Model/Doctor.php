<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'hvpetxch_m5_doctor';
    public $timestamps = false;
    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'date-of-birth',
        'specializtion',
        'create-info_id',
        'position_id'
    ];

    protected $casts = [
        'date-of-birth' => 'date',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function getFullNameDoctor(): string
    {
        return trim("{$this->surname} {$this->name} {$this->patronymic}");
    }
}