<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pencapaian extends Model
{
    /** @use HasFactory<\Database\Factories\PencapaianFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'penyelenggara', 'tanggal_pencapaian', 'dokumen', 'resume_id'];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
