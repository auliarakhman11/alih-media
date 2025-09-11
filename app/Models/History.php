<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';
    protected $fillable = ['berkas_id','proses_id','dari','user_id','ket','user_ket','selesai'];

    public function user()
    {
        return $this->belongsTo(User::class,'dari','id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function proses()
    {
        return $this->belongsTo(Proses::class,'proses_id','id');
    }

    public function berkas()
    {
        return $this->belongsTo(Berkas::class,'berkas_id','id');
    }

}
