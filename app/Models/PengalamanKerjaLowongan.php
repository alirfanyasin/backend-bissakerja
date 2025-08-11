<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengalamanKerjaLowongan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengalaman_kerja_lowongan';

    protected $fillable = [
        'nama',
    ];
}
