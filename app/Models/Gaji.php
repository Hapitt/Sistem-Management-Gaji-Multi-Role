<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji';
    protected $primaryKey = 'id_gaji';
    public $timestamps = true;

    protected $fillable = [
        'id_karyawan',
        'id_lembur',
        'periode',
        'lama_lembur',
        'total_lembur',
        'total_bonus',
        'total_tunjangan',
        'total_pendapatan',
        'serahkan',
        'tanggal_serah', // tambahkan field baru
    ];

    protected $casts = [
        'tanggal_serah' => 'datetime',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function lembur()
    {
        return $this->belongsTo(Lembur::class, 'id_lembur', 'id_lembur');
    }

    // Scope untuk gaji yang belum diserahkan
    public function scopeBelumDiserahkan($query)
    {
        return $query->where('serahkan', 'belum');
    }

    // Scope untuk gaji yang sudah diserahkan
    public function scopeSudahDiserahkan($query)
    {
        return $query->where('serahkan', 'sudah');
    }
}
