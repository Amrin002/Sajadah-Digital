<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasis';

    protected $fillable = [
        'users_id',
        'nama',
        'latitude',
        'longitude',
        'zona_waktu',
        'negara',
        'kota',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function jadwalSholat()
    {
        return $this->hasMany(JadwalSholat::class, 'lokasis_id');
    }

    public function kompasKiblat()
    {
        return $this->hasOne(KompasKiblat::class, 'lokasis_id');
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    // Methods
    public function setAktif()
    {
        // Nonaktifkan semua lokasi user
        $this->user->lokasi()->update(['is_active' => false]);

        // Aktifkan lokasi ini
        $this->update(['is_active' => true]);
    }

    public function getJadwalHariIni()
    {
        return $this->jadwalSholat()
            ->whereDate('tanggal', today())
            ->first();
    }
}
