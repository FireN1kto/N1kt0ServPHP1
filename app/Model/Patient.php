<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patient';
    public $timestamps = false;
    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'date-of-birth',
        'createInfo_id',
    ];

    protected $casts = [
        'date-of-birth' => 'date',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function getFullNamePatient(): string
    {
        return trim("{$this->surname} {$this->name} {$this->patronymic}");
    }
}