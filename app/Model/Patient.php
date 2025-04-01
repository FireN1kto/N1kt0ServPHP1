<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'patient';

    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'date-of-birth',
        'create-info-id'
    ];

    protected $casts = [
        'date-of-birth' => 'date',
    ];

    public function createInfoId(): BelongsTo
    {
        return $this->belongsTo(CreateInfo::class, 'create-info-id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient-id');
    }

    public function getFullNamePatient(): string
    {
        return trim("{$this->surname} {$this->name} {$this->patronymic}");
    }
}