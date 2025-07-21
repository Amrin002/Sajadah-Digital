<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanSholat extends Model
{
    use HasFactory;

    protected $table = 'catatan_sholats';

    protected $fillable = [
        'users_id',
        'tanggal',
        'nama_sholat',
        'sudah_sholat',
        'waktu_sholat',
        'status_sholat',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'sudah_sholat' => 'boolean',
        'waktu_sholat' => 'datetime:H:i',
    ];

    // Relationships
    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Scopes
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal', today());
    }

    public function scopeSudahSholat($query)
    {
        return $query->where('sudah_sholat', true);
    }

    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year);
    }

    // Methods
    public function tandaiSudahSholat($status = 'tepat_waktu', $catatan = null)
    {
        $this->update([
            'sudah_sholat' => true,
            'waktu_sholat' => now(),
            'status_sholat' => $status,
            'catatan' => $catatan,
        ]);
    }

    public static function getStatistikBulanIni($usersId)
    {
        $total = static::where('users_id', $usersId)
            ->bulanIni()
            ->count();

        $sudah = static::where('users_id', $usersId)
            ->bulanIni()
            ->sudahSholat()
            ->count();

        return [
            'total' => $total,
            'sudah' => $sudah,
            'persentase' => $total > 0 ? round(($sudah / $total) * 100) : 0,
        ];
    }
}
