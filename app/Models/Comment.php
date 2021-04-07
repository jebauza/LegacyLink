<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\DeceasedProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = ['title','message'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $appends = ['file'];

    // Attributes
    function getFileAttribute()
    {
        return Storage::disk('public')->exists($this->path_file) ? Storage::disk('public')->url($this->path_file) : null;
    }

    /**
     * Get the user that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(DeceasedProfile::class, 'profile_id', 'id');
    }

    public function hasModeration($role)
    {
        if ($role == 'close_friend') {
            return true;
        }

        return false;
    }
}
