<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masjid extends Model
{
    use HasFactory;

    protected $table = 'masjid';

    protected $fillable = [
        'nama',
        'alamat',
        'latitude',
        'longitude',
        'telepon',
        'fasilitas',
        'sumber_jadwal_sholat',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'fasilitas' => 'array',
    ];

    // Relationships
    // public function penggunaFavorit()
    // {
    //     return $this->belongsToMany(Pengguna::class, 'masjid_favorit_pengguna', 'masjid_id', 'pengguna_id')
    //         ->withPivot('catatan')
    //         ->withTimestamps();
    // }

    // Scopes
    public function scopeTerdekat($query, $latitude, $longitude, $radius = 10)
    {
        return $query->selectRaw(
            "*, 
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
            cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
            sin(radians(latitude)))) AS jarak",
            [$latitude, $longitude, $latitude]
        )
            ->having('jarak', '<=', $radius)
            ->orderBy('jarak');
    }

    // Methods
    public function hitungJarak($latitude, $longitude)
    {
        $earthRadius = 6371; // km

        $latFrom = deg2rad($latitude);
        $lonFrom = deg2rad($longitude);
        $latTo = deg2rad($this->latitude);
        $lonTo = deg2rad($this->longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

    public function isFavoritedBy($pengguna)
    {
        if (!$pengguna) return false;

        return $this->penggunaFavorit()
            ->where('pengguna_id', $pengguna->id)
            ->exists();
    }
}
