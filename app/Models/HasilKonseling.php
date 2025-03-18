<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKonseling extends Model
{
    use HasFactory;

    protected $table = 'hasil_konseling';

    protected $fillable = ['request_konseling_id', 'nama', 'nim', 'file', 'keterangan'];

    public function requestKonseling()
    {
        return $this->belongsTo(RequestKonseling::class, 'request_konseling_id');
    }
}
