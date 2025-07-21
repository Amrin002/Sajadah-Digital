<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    use HasFactory;

    protected $table = 'user_settings';

    protected $fillable = [
        'users_id',
        'metode_perhitungan_id',
        'metode_ashar',
        'aturan_lintang_tinggi',
        'format_waktu',
        'suara_notifikasi',
        'tema',
        'bahasa',
    ];

    // Relationships
    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function metodePerhitungan()
    {
        return $this->belongsTo(MetodePerhitungan::class, 'metode_perhitungans_id');
    }

    // Methods
    public static function createDefault($usersId)
    {
        $metodePerhitungan = MetodePerhitungan::getDefault();

        return static::create([
            'users_id' => $usersId,
            'metode_perhitungans_id' => $metodePerhitungan->id,
            'metode_ashar' => 'Syafii',
            'aturan_lintang_tinggi' => 'TengahMalam',
            'format_waktu' => '24',
            'suara_notifikasi' => 'default',
            'tema' => 'sistem',
            'bahasa' => 'id',
        ]);
    }
}
