<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctor';
    public $timestamps = false;
    protected $fillable = [
        'surname',
        'name',
        'patronymic',
        'date-of-birth',
        'specialization',
        'createInfo_id',
        'position_id'
    ];

    protected $casts = [
        'date-of-birth' => 'date',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function getFullNameDoctor(): string
    {
        return trim("{$this->surname} {$this->name} {$this->patronymic}");
    }
}