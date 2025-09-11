<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisHak extends Model
{
    use HasFactory;

    protected $table = 'jenis_hak';
    protected $fillable = ['nm_hak'];
}
