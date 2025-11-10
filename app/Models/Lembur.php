<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $table = 'lembur';
    protected $primaryKey = 'id_lembur';
    public $timestamps = true;

    protected $fillable = [
        'tarif',
    ];

    public function gaji()
    {
        return $this->hasMany(Gaji::class, 'id_lembur', 'id_lembur');
    }
}
