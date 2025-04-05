<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointment';

    public $timestamps = false;

    protected $fillable = [
        'appointment_date',
        'appointment_time',
        'title',
        'symptoms',
        'createInfo_id',
        'doctor_id',
        'patient_id'
    ];

    protected $casts = [
        'appointment_date' => 'date:Y-m-d',
        'appointment_time' => 'datetime:H:i'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function createInfo()
    {
        return $this->belongsTo(CreatedInfo::class, 'createInfo_id');
    }
}