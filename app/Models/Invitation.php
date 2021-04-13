<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Str;
use App\Models\DeceasedProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $table = 'invitations';

    protected $fillable = ['role'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($invitation) {
            $invitation->token = str_shuffle(Str::random(8)) . uniqid();
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Get the user that owns the Invitation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(DeceasedProfile::class, 'profile_id');
    }
}
