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
        'dateOfBirth',
        'createInfo_id',
    ];

    protected $casts = [
        'dateOfBirth' => 'date',
    ];

    public function createInfo()
    {
        return $this->belongsTo(CreatedInfo::class, 'createInfo_id');
    }


    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function getFullNamePatient(): string
    {
        return trim("{$this->surname} {$this->name} {$this->patronymic}");
    }
}