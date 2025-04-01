<?php

namespace Model;

use Couchbase\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    use HasFactory;

    protected $table = 'hvpetxch_m5_users';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'login',
        'password'
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

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function createdAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'create-info_id');
    }

    public function isAdmin(): bool
    {
        return $this->role_id === 1;
    }
}