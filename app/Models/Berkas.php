<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berkas extends Model
{
    use HasFactory;

    protected $table = 'berkas';
    protected $fillable = ['induk_id','kecamatan_id','kelurahan_id','jenis_hak_id','no_hak','no_peta','tahun_peta','jenis_peta_id','nib','file_name','nm_pemohon','percepatan','selesai','ket','nibel'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class,'kecamatan_id','id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class,'kelurahan_id','id');
    }

    public function jenis_hak()
    {
        return $this->belongsTo(JenisHak::class,'jenis_hak_id','id');
    }

    public function jenis_peta()
    {
        return $this->belongsTo(JenisPeta::class,'jenis_peta_id','id');
    }

    public function history()
    {
        return $this->hasMany(History::class,'berkas_id','id')->orderBy('id','DESC');
    }

}
