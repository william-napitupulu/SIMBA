<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable; // Tambahkan trait Notifiable
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nim', 'username', 'ID_Dosen', 'ID_Perwalian', 'nama', 'kelas'];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'ID_Dosen', 'id');
    }

    public function perwalian()
    {
        return $this->belongsTo(Perwalian::class, 'ID_Perwalian', 'ID_Perwalian');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'nim', 'nim');
    }

    public function requestKonseling()
    {
        return $this->hasMany(RequestKonseling::class, 'nim', 'nim');
    }
}