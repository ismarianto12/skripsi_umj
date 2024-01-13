<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];

    public static function getDatajadwal($id)
    {
        $data = DB::table('jadwal')
            ->select(
                'jadwal.id as jadwal_id',
                'jadwal.mapel_id',
                'jadwal.kelas_id',
                'jadwal.pertemuan',
                'jadwal.sesi',
                'jadwal.jumlah_siswa',
                'jadwal.guru_id',
                'jadwal.crated_at',
                'jadwal.updated_at',
                'jadwal.user_id',
                'jadwal.created_at',
                'kelas.kelas',
                'kelas.tingkat',
                'karyawan.nama as guru_pengampu',
                'users.name',
                'mapel.nama_mapel',
                'mapel.kode'
            )
            ->join('kelas', 'jadwal.kelas_id', '=', 'kelas.kelas', 'left')
            ->join('karyawan', 'jadwal.guru_id', '=', 'karyawan.id', 'left')
            ->join('mapel', 'mapel.id', '=', 'jadwal.mapel_id', 'left')
            ->join('users', 'jadwal.user_id', '=', 'users.id', 'left')
            ->groupBy('jadwal.id')
            ->where('jadwal.id', $id)->first();
        return $data;

    }


}
