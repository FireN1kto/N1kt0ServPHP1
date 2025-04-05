<?php

namespace Model;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    use HasFactory;

    protected $table = 'users';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'login',
        'password',
        'role_id',
        'appointment_id',
        'patient_id',
        'doctor_id',
    ];

    protected $hidden = ['password'];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->password = md5($user->password);
        });
    }

    public function findIdentity(int $id)
    {
        return self::where('id', $id)->first();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function attemptIdentity(array $credentials)
    {
        return self::where(['login' => $credentials['login'],
            'password' => md5($credentials['password'])])->first();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function createdAppointments()
    {
        return $this->hasMany(Appointment::class, 'create-info_id');
    }

    public static function adminExists():bool
    {
        return self::whereHas('role', function ($query) {
            $query->where('name_role', 'admin');
        })->exists();
    }

    public function isregistrationOfficer(): bool
    {
        return $this->role && $this->role->name_role === 'registration_officer';
    }
}