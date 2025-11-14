<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'foto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // <- perbaikan di sini
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => \App\Enums\UserRole::class,
    ];

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'user_id', 'id');
    }

    // Tambahkan method untuk mendapatkan divisi manager
    public function getDivisiManager()
    {
        // Jika user adalah manager dan memiliki data karyawan terkait
        if ($this->role === 'manager' && $this->karyawan) {
            return $this->karyawan->divisi;
        }

        return null;
    }

    // Method untuk mengecek apakah user bisa mengakses data divisi tertentu
    public function canAccessDivisi($divisi)
    {
        if ($this->role === 'admin') {
            return true;
        }

        if ($this->role === 'manager') {
            return $this->getDivisiManager() === $divisi;
        }

        return false;
    }

    // Method untuk mendapatkan karyawan yang se-divisi (untuk manager)
    public function getKaryawanSeDivisi()
    {
        if ($this->role !== 'manager') {
            return collect();
        }

        $divisiManager = $this->getDivisiManager();
        if (!$divisiManager) {
            return collect();
        }

        return Karyawan::where('divisi', $divisiManager)->get();
    }
}

