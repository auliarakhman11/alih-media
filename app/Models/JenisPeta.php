<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPeta extends Model
{
    use HasFactory;

    protected $table = 'jenis_peta';
    protected $fillable = ['nm_jenis_peta'];

}
