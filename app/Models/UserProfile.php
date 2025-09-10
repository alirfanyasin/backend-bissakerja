<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserProfile extends Model
{
    /** @use HasFactory<\Database\Factories\UserProfileFactory> */
    use HasFactory;

    protected $fillable = ['nik', 'tanggal_lahir', 'jenis_kelamin', 'latar_belakang', 'no_telp', 'status_kawin', 'user_id', 'disabilitas_id', 'deleted_at', 'is_experience', 'is_employment'];

    public function disabilitas()
    {
        return $this->belongsTo(Disabilitas::class);
    }

    public function recruitment(): HasMany
    {
        return $this->hasMany(Recruitment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lokasi()
    {
        return $this->hasOne(LokasiKtp::class);
    }

    public function resume()
    {
        return $this->hasOne(Resume::class);
    }
}
