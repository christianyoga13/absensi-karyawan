<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'latitude_masuk',
        'longitude_masuk',
        'alamat_masuk',
        'jam_keluar',
        'latitude_keluar',
        'longitude_keluar',
        'alamat_keluar',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDurasiKerjaAttribute()
    {
        if ($this->jam_masuk && $this->jam_keluar) {
            $masuk = Carbon::createFromFormat('H:i:s', $this->jam_masuk);
            $keluar = Carbon::createFromFormat('H:i:s', $this->jam_keluar);
            
            if ($keluar->lt($masuk)) {
                $keluar->addDay(); 
            }
            
            $diff = $masuk->diffInHours($keluar, false);
            return round($diff, 1);
        }
        return 0;
    }

    public function getStatusLengkapAttribute()
    {
        if ($this->jam_masuk && $this->jam_keluar) {
            return 'Lengkap';
        } elseif ($this->jam_masuk && !$this->jam_keluar) {
            return 'Belum Pulang';
        } else {
            return 'Tidak Masuk';
        }
    }
}
