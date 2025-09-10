<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruitment extends Model
{
    /** @use HasFactory<\Database\Factories\RecruitmentFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'post_lowongan_id', 'status_candidate', 'status_perusahaan', 'perusahaan_profile_id', 'user_profile_id'];

    public function userProfile(): BelongsTo
    {
        return $this->belongsTo(UserProfile::class);
    }

    public function perusahaanProfile(): BelongsTo
    {
        return $this->belongsTo(PerusahaanProfile::class);
    }

    public function postLowongan(): BelongsTo
    {
        return $this->belongsTo(PostLowongan::class);
    }
}
