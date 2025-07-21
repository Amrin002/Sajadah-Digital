<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggalHijriyah extends Model
{
    use HasFactory;

    protected $table = 'tanggal_hijriyahs';

    protected $fillable = [
        'tanggal_masehi',
        'hari_hijriyah',
        'bulan_hijriyah',
        'tahun_hijriyah',
        'nama_bulan_hijriyah',
        'hari_libur',
        'nama_hari_libur',
    ];

    protected $casts = [
        'tanggal_masehi' => 'date',
        'hari_libur' => 'boolean',
        'hari_hijriyah' => 'integer',
        'bulan_hijriyah' => 'integer',
        'tahun_hijriyah' => 'integer',
    ];

    // Scopes
    public function scopeHariLibur($query)
    {
        return $query->where('hari_libur', true);
    }

    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal_masehi', now()->month)
            ->whereYear('tanggal_masehi', now()->year);
    }

    // Methods
    public static function getHariIni()
    {
        return static::whereDate('tanggal_masehi', today())->first();
    }

    public function getFormatLengkapAttribute()
    {
        return "{$this->hari_hijriyah} {$this->nama_bulan_hijriyah} {$this->tahun_hijriyah}H";
    }
}
