<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Appointment extends Model
{
    use HasFactory;

    protected $table = 'hvpetxch_m5_appointment';

    protected $fillable = [
        'appointment_date',
        'appointment_time',
        'title',
        'symptoms',
        'create-info_id',
        'doctor_id',
        'patient_id'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i'
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function createInfo(): BelongsTo
    {
        return $this->belongsTo(CreateInfo::class, 'create-info_id');
    }
}