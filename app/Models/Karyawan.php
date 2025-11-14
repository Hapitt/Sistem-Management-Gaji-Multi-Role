<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    public $timestamps = true; 

    protected $fillable = [
        'user_id',
        'id_jabatan',
        'id_rating',
        'nama',
        'divisi',
        'alamat',
        'umur',
        'jenis_kelamin',
        'status',
        'foto',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id_jabatan');
    }

    
    public function rating()
    {
        return $this->belongsTo(Rating::class, 'id_rating', 'id_rating');
    }

    
    public function gaji()
    {
        return $this->hasMany(Gaji::class, 'id_karyawan', 'id_karyawan');
    }
}
