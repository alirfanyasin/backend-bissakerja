<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keterampilan extends Model
{
    /** @use HasFactory<\Database\Factories\KeterampilanFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_keterampilan',
        'resume_id'
    ];

    protected $casts = [
        'nama_keterampilan' => 'array',
    ];

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }
}
