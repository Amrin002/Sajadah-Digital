<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class JadwalSholat extends Model
{

    use HasFactory;

    protected $table = 'jadwal_sholats';

    protected $fillable = [
        'lokasi_id',
        'tanggal',
        'subuh',
        'terbit',
        'dzuhur',
        'ashar',
        'maghrib',
        'isya',
    ];
    protected $casts = [
        'tanggal' => 'date',
        'subuh' => 'datetime:H:i',
        'terbit' => 'datetime:H:i',
        'dzuhur' => 'datetime:H:i',
        'ashar' => 'datetime:H:i',
        'maghrib' => 'datetime:H:i',
        'isya' => 'datetime:H:i',
    ];

    // Relationships
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }


    // Accessors
    public function getWaktuSholatAttribute()
    {
        return [
            'subuh' => $this->subuh,
            'dzuhur' => $this->dzuhur,
            'ashar' => $this->ashar,
            'maghrib' => $this->maghrib,
            'isya' => $this->isya,
        ];
    }

    public function getSholatBerikutnyaAttribute()
    {
        $now = now();
        $waktuSholat = [
            'subuh' => Carbon::parse($this->subuh),
            'dzuhur' => Carbon::parse($this->dzuhur),
            'ashar' => Carbon::parse($this->ashar),
            'maghrib' => Carbon::parse($this->maghrib),
            'isya' => Carbon::parse($this->isya),
        ];

        foreach ($waktuSholat as $nama => $waktu) {
            if ($now->lt($waktu)) {
                return [
                    'nama' => $nama,
                    'waktu' => $waktu,
                    'sisa_waktu' => $now->diff($waktu),
                ];
            }
        }

        // Jika sudah lewat Isya, return Subuh besok
        return [
            'nama' => 'subuh',
            'waktu' => Carbon::parse($this->subuh)->addDay(),
            'sisa_waktu' => $now->diff(Carbon::parse($this->subuh)->addDay()),
        ];
    }

    // Scopes
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year);
    }
}
