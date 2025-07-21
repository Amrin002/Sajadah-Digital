<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KompasKiblat extends Model
{
    use HasFactory;

    protected $table = 'kompas_kiblats';

    protected $fillable = [
        'lokasi_id',
        'arah_kiblat',
        'deklinasi_magnetik',
        'terakhir_kalibrasi',
    ];

    protected $casts = [
        'arah_kiblat' => 'decimal:2',
        'deklinasi_magnetik' => 'decimal:2',
        'terakhir_kalibrasi' => 'datetime',
    ];

    // Relationships
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasis_id');
    }

    // Methods
    public function kalibrasi()
    {
        $this->update(['terakhir_kalibrasi' => now()]);
    }

    public function hitungArahKiblat($latitude, $longitude)
    {
        // Koordinat Ka'bah
        $latKaabah = deg2rad(21.4225);
        $lonKaabah = deg2rad(39.8262);

        $lat = deg2rad($latitude);
        $lon = deg2rad($longitude);

        $dLon = $lonKaabah - $lon;

        $y = sin($dLon) * cos($latKaabah);
        $x = cos($lat) * sin($latKaabah) - sin($lat) * cos($latKaabah) * cos($dLon);

        $bearing = atan2($y, $x);
        $bearing = rad2deg($bearing);
        $bearing = fmod($bearing + 360, 360);

        return round($bearing, 2);
    }
}
