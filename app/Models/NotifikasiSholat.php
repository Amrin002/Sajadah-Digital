<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiSholat extends Model
{
    use HasFactory;

    protected $table = 'notifikasi_sholats';

    protected $fillable = [
        'users_id',
        'nama_sholat',
        'aktif',
        'menit_sebelum',
        'jenis_notifikasi',
        'path_suara_khusus',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'menit_sebelum' => 'integer',
    ];

    // Relationships
    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    // Methods
    public static function createDefaultForusers($usersId)
    {
        $waktuSholat = ['subuh', 'dzuhur', 'ashar', 'maghrib', 'isya'];

        foreach ($waktuSholat as $sholat) {
            static::create([
                'users_id' => $usersId,
                'nama_sholat' => $sholat,
                'aktif' => true,
                'menit_sebelum' => 0,
                'jenis_notifikasi' => 'adzan',
            ]);
        }
    }
}
