<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'rating';
    protected $primaryKey = 'id_rating';
    public $timestamps = true;

    protected $fillable = [
        'rating',
        'presentase_bonus',
    ];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class, 'id_rating', 'id_rating');
    }
}
