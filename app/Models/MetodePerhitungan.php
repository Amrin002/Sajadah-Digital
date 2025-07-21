<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePerhitungan extends Model
{
    use HasFactory;

    protected $table = 'metode_perhitungans';

    protected $fillable = [
        'nama',
        'kode',
        'sudut_subuh',
        'sudut_isya',
        'menit_maghrib',
        'menit_isya',
        'metode_tengah_malam',
        'deskripsi',
    ];

    protected $casts = [
        'sudut_subuh' => 'decimal:2',
        'sudut_isya' => 'decimal:2',
        'menit_maghrib' => 'integer',
        'menit_isya' => 'integer',
    ];

    // Relationships
    public function pengaturanPengguna()
    {
        return $this->hasMany(UserSettings::class, 'metode_perhitungan_id');
    }

    // Scopes
    public function scopeKemenag($query)
    {
        return $query->where('kode', 'KEMENAG');
    }

    // Methods
    public static function getDefault()
    {
        return static::where('kode', 'KEMENAG')->first();
    }
}
